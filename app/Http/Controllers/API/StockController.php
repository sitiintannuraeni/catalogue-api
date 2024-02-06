<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use Validator;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $stock = Stock::all();
        if($stock->isEmpty())
        {
            return response()->json([
                'message' => 'Data Stock Kosong',
                'error' => true
            ], 404); //404 not found
        }

        return response()->json([
            'data' => $stock,
            'message' => 'Data Stock Ditemukan',
            'status' => 200
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'size_id' => 'required',
            'product_id' => 'required',
            'stock' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'message' => 'Ada Kesalahan',
                'data' => $validator->errors()
            ], 400);
        }

        $stock = Stock::create([
            'size_id' => $request->size_id,
            'product_id' => $request->product_id,
            'stock' => $request->stock,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Berhasil menambahkan data stock',
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
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $stock = Stock::find($id);
    
        if (!$stock) {
            return response()->json([
                'status' => 400,
                'message' => 'Data tidak ditemukan'
            ], 400);
        }
    
        $validator = Validator::make($request->all(), [
            'size_id' => 'required',
            'product_id' => 'required',
            'stock' => 'required|integer',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Gagal melakukan update data!',
                'data' => $validator->errors()
            ], 400);
        }
    
        $stock->size_id = $request->input('size_id');
        $stock->product_id = $request->input('product_id');
        $stock->stock = $request->input('stock');
    
    
        $stock->save();
    
        return response()->json([
            'status' => 200,
            'message' => 'Sukses Update Data'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id) {
        $stock = Stock::find($id);
    
        if (!$stock) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    
    
        $stock->delete();
    
        return response()->json([
            'status' => true,
            'message' => 'Sukses Hapus Data'
        ]);
    }
}
