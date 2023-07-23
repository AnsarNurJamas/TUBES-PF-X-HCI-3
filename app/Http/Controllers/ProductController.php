<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        {
            $pageTitle = 'Product';

            $products = Product::all();
            return view('Product.index', [
                'pageTitle' => $pageTitle,
                'product' => $products
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Tambahkan Product';
        return view('Product.create', ['pageTitle' => $pageTitle]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => 'Kolom Ini Harus Diisi.',
            'numeric' => 'Isi :attribute dengan angka',
            'kodeproduk.unique' => 'kode barang sudah ada',
        ];

        $validator = Validator::make($request->all(), [
            'kodeproduk' => 'required|unique:products,kodeproduk',
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'status' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();


        }

        $image_path = '';

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('products', 'public');
        }

        $product = New Product;
        $product->kodeproduk = $request->kodeproduk;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->image = $image_path;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->status= $request->status;
        $product->save();

        return redirect()->route('Product.index');
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
        $pageTitle = 'Edit Produk';

        $product = Product::find($id);

        return view('Product.edit', compact('pageTitle', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       ///
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       //
    }
}
