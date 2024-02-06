<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = Category::all();
        if($category->isEmpty())
        {
            return response()->json([
                'message' => 'Data Order Kosong',
                'error' => true
            ], 404); //404 not found
        }

        return response()->json([
            'data' => $category,
            'message' => 'Data Order Ditemukan',
            'error' => false
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Ada Kesalahan',
                'data' => $validator->errors()
            ]);
        }

        $category = Category::create([
            'category_name' => $request->category_name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan data category'
        ]);
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
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
    
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    
        $validator = Validator::make($request->all(), [
            'category_name' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal melakukan update data!',
                'data' => $validator->errors()
            ]);
        }
    
        $category->category_name = $request->input('category_name');
    
    
        $category->save();
    
        return response()->json([
            'status' => true,
            'message' => 'Sukses Update Data'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id) {
        $category = Category::find($id);
    
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    
    
        $category->delete();
    
        return response()->json([
            'status' => true,
            'message' => 'Sukses Hapus Data'
        ]);
    }
}
