<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    // ADMIN: daftar pembayaran
    public function index()
    {
        $payments = Payment::with('order.user')
            ->latest()
            ->get();

        return view(
            'admin.payments.index',
            compact('payments')
        );
    }

    // CUSTOMER: halaman konfirmasi pembayaran
    public function confirmation(int $order_id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with('payment')
            ->findOrFail($order_id);

        return view(
            'user.payment.confirmation',
            compact('order')
        );
    }


    // CUSTOMER: menyimpan atau memperbarui bukti pembayaran
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'metode_pembayaran' => 'required|string',
            'total_bayar' => 'required|numeric|min:0',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $order = Order::where('user_id', Auth::id())
            ->with('payment')
            ->findOrFail($data['order_id']);

        // COD tidak membutuhkan bukti transfer
        if (strtoupper($order->metode_pembayaran) === 'COD') {
            if (!$order->payment) {
                Payment::create([
                    'order_id' => $order->id,
                    'metode_pembayaran' => 'COD',
                    'total_bayar' => $order->total_harga,
                    'bukti_pembayaran' => null,
                    'status' => 'menunggu',
                ]);
            }

            return redirect()
                ->route('orders.index')
                ->with('success', 'Pesanan COD berhasil dicatat.');
        }

        $payment = $order->payment;

        // Jika pembayaran sudah ada, hanya status buram atau gagal
        // yang boleh mengunggah bukti pengganti.
        if ($payment && !in_array($payment->status, ['buram', 'gagal'])) {
            return back()->with(
                'error',
                'Pembayaran ini sedang diproses atau sudah terverifikasi.'
            );
        }

        // Bukti wajib disertakan untuk pembayaran baru atau penggantian bukti
        if (!$request->hasFile('bukti_pembayaran')) {
            return back()
                ->withErrors([
                    'bukti_pembayaran' => 'Silakan pilih bukti pembayaran yang baru.',
                ])
                ->withInput();
        }

        // Simpan file bukti yang baru
        $file = $request->file('bukti_pembayaran');
        $filename = 'payment-' . uniqid() . '.' . $file->extension();

        $file->storeAs('payments', $filename, 'public');

        if ($payment) {
            // Hapus file lama setelah file baru berhasil disimpan
            if ($payment->bukti_pembayaran) {
                Storage::disk('public')->delete(
                    'payments/' . $payment->bukti_pembayaran
                );
            }

            // Perbarui pembayaran yang sama, bukan membuat data baru
            $payment->update([
                'metode_pembayaran' => $data['metode_pembayaran'],
                'total_bayar' => $data['total_bayar'],
                'bukti_pembayaran' => $filename,
                'status' => 'menunggu',
            ]);
        } else {
            // Buat data pembayaran jika memang belum pernah ada
            Payment::create([
                'order_id' => $order->id,
                'metode_pembayaran' => $data['metode_pembayaran'],
                'total_bayar' => $data['total_bayar'],
                'bukti_pembayaran' => $filename,
                'status' => 'menunggu',
            ]);
        }

        return redirect()
            ->route('orders.index')
            ->with(
                'success',
                'Bukti pembayaran berhasil diperbarui dan menunggu verifikasi admin.'
            );
    }
    // ADMIN: menampilkan file bukti pembayaran
    public function proof(string $id)
    {
        $payment = Payment::findOrFail($id);

        if (!$payment->bukti_pembayaran) {
            abort(404, 'Bukti pembayaran belum tersedia.');
        }

        $path = Storage::disk('public')->path(
            'payments/' . $payment->bukti_pembayaran
        );

        if (!file_exists($path)) {
            abort(
                404,
                'File bukti pembayaran tidak ditemukan di storage.'
            );
        }

        return response()->file($path);
    }

    // ADMIN: detail pembayaran
    public function show(string $id)
    {
        $payment = Payment::with('order.user')
            ->findOrFail($id);

        return view(
            'admin.payments.show',
            compact('payment')
        );
    }


    // ADMIN: update status pembayaran
    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,verifikasi,lunas,buram,gagal',
        ]);

        $payment = Payment::with('order')->findOrFail($id);

        $payment->update([
            'status' => $request->status,
        ]);

        // Jika pembayaran diterima, pesanan dilanjutkan ke dapur
        if ($request->status === 'lunas') {
            $payment->order->update([
                'status' => 'diproses',
            ]);
        }

        return redirect()
            ->route('admin.payments.show', $payment->id)
            ->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    // ADMIN: menghapus pembayaran
    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);

        $payment->delete();

        return redirect()
            ->route('admin.payments.index')
            ->with(
                'success',
                'Data pembayaran berhasil dihapus.'
            );
    }
}
