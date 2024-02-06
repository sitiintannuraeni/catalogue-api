<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;
use Validator;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $size = Size::all();
        if($size->isEmpty())
        {
            return response()->json([
                'message' => 'Data Size Kosong',
                'error' => true
            ], 404); //404 not found
        }

        return response()->json([
            'data' => $size,
            'message' => 'Data Size Ditemukan',
            'status' => 200
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'size_name' => 'required',
            'label' => 'required',
            'description' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'message' => 'Ada Kesalahan',
                'data' => $validator->errors()
            ], 400);
        }

        $size = Size::create([
            'size_name' => $request->size_name,
            'label' => $request->label,
            'description' => $request->description
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Berhasih menambahkan data size'
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
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $size = Size::find($id);
    
        if (!$size) {
            return response()->json([
                'status' => 400,
                'message' => 'Data tidak ditemukan'
            ], 400);
        }
    
        $validator = Validator::make($request->all(), [
            'size_name' => 'required',
            'label' => 'required',
            'description' => 'required|string|max:500'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Gagal melakukan update data!',
                'data' => $validator->errors()
            ], 400);
        }
    
        $size->size_name = $request->input('size_name');
        $size->label = $request->input('label');
        $size->description = $request->input('description');
    
        $size->save();
    
        return response()->json([
            'status' => 200,
            'message' => 'Sukses Update Data'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id) {
        $size = Size::find($id);
    
        if (!$size) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    
    
        $size->delete();
    
        return response()->json([
            'status' => 200,
            'message' => 'Sukses Hapus Data'
        ], 200);
    }
}
