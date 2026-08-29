<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with('order.user')->get();

        return view('payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'metode_pembayaran' => 'required|string',
            'total_pembayaran' => 'required|integer|min:0',
            'bukti_pembayaran' => 'nullable|image|mimes:jepg,png,jpg|max:2048',
        ]);

        //cek order punya pelanggan yng login
        $order = Order::where('user_id',Auth::id())
            ->where('id',$data['order_id'])
            ->firstOrFail();

        //cek orderannya udah di bayar belum
        if ($order->payment) {
            return back()->with('error','pembayaran sudah pernah dibuat');
        }
        
        //status awal
        $data['status'] = 'Menunggu';

        //upload bukti pembayaran
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = 'payment-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/payments', $filename);
            $data['bukti_pembayaran'] = $filename;
        }

        Payment::create($data);

        return redirect()->route('order.index')
            ->with('success','pembayaran berhasil dicatat!Menunggu verivikasi admin.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, string $id)
    {
        //validasi status
        $request->validate([
            'status' => 'required|in:menunggu,verifikasi,lunas,gagal'
        ]);

        //cari bayar berdasarkan id
        $payment = Payment::findOrFail($id);
        
        //update status
        $payment->update([
            'status' => $request->status,
        ]);

        //kalo lunas,update status order jg
        if ($request->status === 'lunas') {
            $payment->order->update(['status' => 'diproses']);
        }

        return redirect()->route('payments.index')
            ->with('success', 'Status pembayaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
