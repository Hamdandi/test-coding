<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $order = Order::all();
        return view('order.index', [
            'order' => $order
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $kendaraan = Kendaraan::all();
        return view('order.create', [
            'kendaraan' => $kendaraan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_customer' => 'nullable',
            'kendaraan_id' => 'required',
            'tanggal_sewa' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_sewa',
        ]);

        $sewaStart = new \DateTime($validatedData['tanggal_sewa']);
        $sewaEnd = new \DateTime($validatedData['tanggal_kembali']);
        $interval = $sewaStart->diff($sewaEnd);
        $daysRented = $interval->days;

        $kendaraan = Kendaraan::findOrFail($validatedData['kendaraan_id']);
        $dailyPrice = (int) $kendaraan->harga_sewa;

        $totalPrice = $daysRented * $dailyPrice;

        $orderData = array_merge($validatedData, [
            'total_harga' => $totalPrice,
            'tanggal_buat_order' => now(),
            'tanggal_ubah_order' => null,
        ]);

        Order::create($orderData);

        return redirect('/sewa')->with('success', 'Data berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return redirect('/orders')->with('error', 'Order not found.');
        }

        $kendaraan = Kendaraan::all();
        return view('order.edit', [
            'order' => $order,
            'kendaraan' => $kendaraan
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'nama_customer' => 'nullable',
            'kendaraan_id' => 'required',
            'tanggal_sewa' => 'nullable|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_sewa',
            'total_harga' => 'nullable|integer',
        ]);

        if (isset($validatedData['tanggal_sewa']) && isset($validatedData['tanggal_kembali'])) {
            $sewaStart = new \DateTime($validatedData['tanggal_sewa']);
            $sewaEnd = new \DateTime($validatedData['tanggal_kembali']);
            $interval = $sewaStart->diff($sewaEnd);
            $daysRented = $interval->days;

            $kendaraan = Kendaraan::findOrFail($validatedData['kendaraan_id']);
            $dailyPrice = (int) $kendaraan->harga_sewa;

            $validatedData['total_harga'] = $daysRented * $dailyPrice;
        }

        $order->update(array_merge($validatedData, [
            'tanggal_ubah_order' => now(),
        ]));

        return redirect('/sewa')->with('success', 'Data berhasil diubah');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
        Order::destroy($order->id);
        return redirect('/sewa')->with('success', 'Data berhasil dihapus');
    }
}
