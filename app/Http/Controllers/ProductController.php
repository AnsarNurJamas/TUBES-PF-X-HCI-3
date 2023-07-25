<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use App\exports\ProductExport;
use PDF;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        {
            $pageTitle = 'Product';

            confirmDelete();

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

        Alert::success('Sukses Menambahkan', 'Sukses Menambahkan Produk.');
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
        $messages = [
            'required' => 'Kolom Ini Harus Diisi.',
            'numeric' => 'Isi :attribute dengan angka',
            'kodeproduk.unique' => 'kode barang sudah ada',
        ];

        $validator = Validator::make($request->all(), [
            'kodeproduk' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'status' => 'required',
        ], $messages);

        $validator->after(function ($validator) use ($request, $id) {
            $value = $request->input('kodeproduk');
            $count = DB::table('products')
                ->where('kodeproduk', $value)
                ->where('id', '<>', $id)
                ->count();

            if ($count > 0) {
                $validator->errors()->add('kodeproduk', 'Kode Produk ini sudah dipakai.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();


        }


        $product = Product::find($id);
        $product->kodeproduk = $request->kodeproduk;
        $product->name = $request->name;
        $product->description = $request->description;
        if ($request->hasFile('image')) {
            // Delete old avatar
            if (Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            // Store avatar
            $image_path = $request->file('image')->store('products', 'public');
            // Save to Database
            $product->image = $image_path;
        }
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->status = $request->status;
        $product->save();

        Alert::success('Sukses Mengubah', 'Sukses Mengubah Produk.');
        return redirect()->route('Product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        Alert::success('Sukses Menghapus', 'Sukses Menghapus Produk.');
        return redirect()->route('Product.index');
    }
    public function exportExcel()
    {
    return Excel::download(new ProductExport, 'product.xlsx');
    }

    public function export1Pdf()
    {
        $product = Product::all();
    
        $pdf = PDF::loadView('Product.export1_pdf', compact('product'));
    
        return $pdf->download('product.pdf');
    }


    }

