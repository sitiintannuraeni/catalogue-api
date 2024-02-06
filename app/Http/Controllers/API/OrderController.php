<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $order = Order::all();
        if($order->isEmpty())
        {
            return response()->json([
                'message' => 'Data Order Kosong',
                'error' => true
            ], 404); //404 not found
        }

        return response()->json([
            'data' => $order,
            'message' => 'Data Order Ditemukan',
            'status' => 200
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_number' => 'required|unique:orders',
            'total_quantity' => 'required|integer',
            'total_price' => 'required|integer|min:10',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'message' => 'Ada Kesalahan',
                'data' => $validator->errors()
            ], 400);
        }

        $order = Order::create([
            'order_number' => $request->order_number,
            'total_quantity' => $request->total_quantity,
            'total_price' => $request->total_price,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Berhasil menambahkan data order',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::find($id);
    
        if (!$order) {
            return response()->json([
                'status' => 400,
                'message' => 'Data tidak ditemukan'
            ], 400);
        }
    
        $validator = Validator::make($request->all(), [
            'order_number' => 'required|unique:orders',
            'total_quantity' => 'required|integer',
            'total_price' => 'required|integer|min:10',
            'status' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Gagal melakukan update data!',
                'data' => $validator->errors()
            ], 400);
        }
    
        $order->order_number = $request->input('order_number');
        $order->total_quantity = $request->input('total_quantity');
        $order->total_price = $request->input('total_price');
        $order->status = $request->input('status');
    
    
        $order->save();
    
        return response()->json([
            'status' => 200,
            'message' => 'Sukses Update Data'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id) {
        $order = Order::find($id);
    
        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    
    
        $order->delete();
    
        return response()->json([
            'status' => true,
            'message' => 'Sukses Hapus Data'
        ]);
    }
}
