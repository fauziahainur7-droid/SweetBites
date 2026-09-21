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

    // CUSTOMER: menyimpan bukti pembayaran
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'metode_pembayaran' => 'required|string',
            'total_bayar' => 'required|numeric|min:0',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $order = Order::where('user_id', Auth::id())
            ->where('id', $data['order_id'])
            ->with('payment')
            ->firstOrFail();

        // COD tidak membutuhkan bukti pembayaran
        if ($order->metode_pembayaran === 'COD') {
            return back()->with(
                'error',
                'Pesanan COD tidak perlu upload bukti pembayaran.'
            );
        }

        // Cek apakah pembayaran sudah pernah dibuat
        if ($order->payment) {
            return back()->with(
                'error',
                'Pembayaran untuk pesanan ini sudah pernah dibuat.'
            );
        }

        // Upload bukti pembayaran
        $file = $request->file('bukti_pembayaran');

        $filename = 'payment-' .
            time() .
            '.' .
            $file->getClientOriginalExtension();

        $file->storeAs(
            'payments',
            $filename,
            'public'
        );

        $data['bukti_pembayaran'] = $filename;

        // Status awal pembayaran
        $data['status'] = 'menunggu';

        // Simpan pembayaran
        Payment::create($data);

        return redirect()
            ->route('orders.index')
            ->with(
                'success',
                'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.'
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
    public function updateStatus(
        Request $request,
        string $id
    ) {
        $request->validate([
            'status' => 'required|in:menunggu,verifikasi,lunas,gagal',
        ]);

        $payment = Payment::findOrFail($id);

        $payment->update([
            'status' => $request->status,
        ]);

        // Jika pembayaran lunas, pesanan menjadi diproses
        if ($request->status === 'lunas') {
            $payment->order->update([
                'status' => 'diproses',
            ]);
        }

        return redirect()
            ->route('admin.payments.index')
            ->with(
                'success',
                'Status pembayaran berhasil diperbarui!'
            );
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