<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Product_image;
use Illuminate\Http\Request;
use Validator;
use Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with('images')->with('size')->get();
        
        return $this->prepareResponse($products);
    }
    
    public function find($id)
    {
        $product = Product::with('images')->with('size')->find($id);
        
        if (!$product) {
            return response()->json([
                'message' => 'Produk tidak ditemukan',
                'error' => true
            ], 404);
        }
        
        return $this->prepareResponse([$product]); // Wrap $product in array as we want to return a collection
    }
    
   private function prepareResponse($products)
{
    // Memastikan bahwa $products adalah sebuah array
    if (!is_array($products)) {
        // Jika bukan array, return response error
        return response()->json([
            'message' => 'Input harus berupa array',
            'status' => 400
        ], 400);
    }

    // Mengonversi array ke koleksi agar dapat menggunakan map()
    $productsCollection = collect($products);

    // Melakukan transformasi menggunakan map()
    $mappedProducts = $productsCollection->map(function ($product) {
        $mappedProductImages = collect($product['images'])->map(function($image) {
            return [
                'name' => $image['name'],
                'path' => $image['path'],
                'url' => url($image['path'])
            ];
        });

        return [
            'id' => $product['id'],
            'category_id' => $product['category_id'],
            'product_name' => $product['product_name'],
            'material' => $product['material'],
            'features' => $product['features'],
            'overview' => $product['overview'],
            'desc' => $product['desc'],
            'price' => $product['price'],
            'total_sold' => $product['total_sold'],
            'size' => $product['size'],
            'images' => $mappedProductImages
        ];
    });
    
    // Mengembalikan respons JSON
    return response()->json([
        'data' => $mappedProducts,
        'message' => 'Data Product Ditemukan',
        'status' => 200
    ]);
}

    

    /**
     * Show the form for creating a new resource.
     */
    // productController create function
public function create(Request $request)
{
    $validator = Validator::make($request->all(), [
        'category_id' => 'required|exists:categories,id',
        'product_name' => 'required',
        'material' => 'required|string',
        'features' => 'required|string',
        'overview' => 'required|string',
        'desc' => 'required|string',
        'price' => 'required|string',
        'total_sold' => 'required|integer|min:10',
        'images.*' => 'required|image|max:13000',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 400,
            'message' => 'Ada Kesalahan',
            'data' => $validator->errors(),
        ], 400);
    }

    // Simpan produk
    // Save product with JSON-encoded image paths
$product = Product::create([
    'category_id' => $request->category_id,
    'product_name' => $request->product_name,
    'material' => $request->material,
    'features' => $request->features,
    'overview' => $request->overview,
    'desc' => $request->desc,
    'price' => 185000,
    'total_sold' => $request->total_sold,
]);

    // Proses harga
    $price = $request->price;
    $price = number_format($price, 0, ',', '.'); // Format harga dengan titik sebagai separator

    // Simpan gambar
    $images = $request->file('images');
    // return dd($images);
    // $image_name = '';
    foreach($images as $image){
        $new_image_name = rand().'.'.$image->getClientOriginalName();
        $image->storeAs('public/images',$new_image_name);
        $image_name = $new_image_name;
        $product_image = Product_image::create([
            'product_id' => $product->id,
            'name' =>  $image_name,
            'path' => 'storage/images/' . $image_name
        ]);
    }

    return response()->json([
        'status' => 200,
        'message' => 'Produk dan gambar berhasil disimpan',
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
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json([
                'status' => 400,
                'message' => 'Data tidak ditemukan'
            ], 400);
        }
    
        $validator = Validator::make($request->all(), [
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'material' => $request->material,
            'features' => $request->features,
            'overview' => $request->overview,
            'desc' => $request->desc,
            'price' => $request->price,
            'total_sold' => $request->total_sold,
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Gagal melakukan update data!',
                'data' => $validator->errors()
            ], 400);
        }
    
        $product->category_id = $request->input('category_id');
        $product->product_name = $request->input('product_name');
        $product->material = $request->input('material');
        $product->features = $request->input('features');
        $product->overview = $request->input('overview');
        $product->desc = $request->input('desc');
        $product->price = $request->input('price');
        $product->total_sold = $request->input('total_sold');
    
    
        $product->save();
    
        return response()->json([
            'status' => 200,
            'message' => 'Sukses Update Data'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id) {
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    
    
        $product->delete();
    
        return response()->json([
            'status' => true,
            'message' => 'Sukses Hapus Data'
        ]);
    }
}
