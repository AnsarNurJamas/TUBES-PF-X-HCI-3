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
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Response;
use Kreait\Firebase\Factory;
use Ramsey\Uuid\Uuid;
use PDF;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function connect()
    {
        $firebase = (new Factory)
                    ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
                    ->withDatabaseUri(env("FIREBASE_DATABASE_URL"));

        return $firebase->createDatabase();
    }
    public function index()
    {
        {
            $pageTitle = 'Product';

            confirmDelete();

        //    $products = Product::all();
            return view('Product.index', [
                'pageTitle' => $pageTitle,
                // 'product' => $products
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Tambahkan Product';
        // $categories = ProductCategory::all();
        $productCategories = $this->connect()->getReference('KategoriProduct')->getSnapshot()->getValue();

        return view('Product.create', [
            'pageTitle' => $pageTitle,
            'productCategories' => $productCategories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $messages = [
        //     'required' => 'Kolom Ini Harus Diisi.',
        //     'numeric' => 'Format Angka',
        //     'product_code.unique' => 'kode barang sudah ada',
        // ];

        // $validator = Validator::make($request->all(), [
        //     'product_code' => 'required|unique:products,product_code',
        //     'name' => 'required',
        //     'purchase_price' => 'required|numeric',
        //     'selling_price' => 'required|numeric',
        //     'stock' => 'required|numeric',
        // ], $messages);

        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();


        // }

        // $image_path = '';

        // if ($request->hasFile('image')) {
        //     $image_path = $request->file('image')->store('products', 'public');
        // }

        // $product = New Product;
        // $product->product_code = $request->product_code;
        // $product->image = $image_path;
        // $product->name = $request->name;
        // $product->selling_price = $request->selling_price;
        // $product->purchase_price = $request->purchase_price;
        // $product->stock = $request->stock;
        // $product->category_id= $request->category_id;
        // $product->save();

        // Alert::success('Sukses Menambahkan', 'Sukses Menambahkan Produk.');
        $data = $request->only(['product_code', 'namaproduct','kategoriproduct', 'hargajual', 'hargabeli', 'stock', 'deskripsiproduct']);
        $productId = Uuid::uuid4()->toString();
        $productCategory = $this->connect()->getReference('KategoriProduct')->getChild($data['kategoriproduct'])->getValue();

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('public/products');
            $gambarName = pathinfo($gambarPath, PATHINFO_FILENAME);

            $firebaseStorage = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->createStorage();

        $bucket = $firebaseStorage->getBucket();
        $bucket->upload(file_get_contents(storage_path("app/{$gambarPath}")), [
            'name' => "images/{$gambarName}.jpg", // Sesuaikan dengan struktur penyimpanan Anda
        ]);


        // Simpan data kategori produk ke Firebase Realtime Database
        $this->connect()->getReference('Product/' . $productId)->set([
            'id' => $productId,
            'product_code' => $data['product_code'],
            'namaproduct' => $data['namaproduct'],
            'hargajual' => $data['hargajual'],
            'hargabeli' => $data['hargabeli'],
            'kategoriproduct' => $productCategory['namakategori'],
            'stock' => $data['stock'],
            'deskripsiproduct' => $data['deskripsiproduct'],
            'gambar' => $gambarName,
            // Add other fields you want to store
        ]);

        return redirect()->route('Product.index');

    }
    return redirect()->back()->with('error', 'Gambar tidak diunggah.');
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
        $categories = ProductCategory::all();

        return view('Product.edit', compact('pageTitle', 'product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'required' => 'Kolom Ini Harus Diisi.',
            'numeric' => 'Format Angka',
            'product_code.unique' => 'kode barang sudah ada',
        ];

        $validator = Validator::make($request->all(), [
            'product_code' => 'required',
            'name' => 'required',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock' => 'required|numeric',
        ], $messages);

        $validator->after(function ($validator) use ($request, $id) {
            $value = $request->input('product_code');
            $count = DB::table('products')
                ->where('product_code', $value)
                ->where('id', '<>', $id)
                ->count();

            if ($count > 0) {
                $validator->errors()->add('product_code', 'Kode Produk ini sudah dipakai.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();

        }

        $product = Product::find($id);
        $product->product_code = $request->product_code;
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
        $product->name = $request->name;
        $product->selling_price = $request->selling_price;
        $product->purchase_price = $request->purchase_price;
        $product->stock = $request->stock;
        $product->category_id= $request->category_id;
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

    public function getProduct(Request $request)
{
    // $product = Product::select(['product_code', 'image','name','selling_price','purchase_price','stock','category_id'])->get();
    $product = Product::all();

    return Response::json($product);
}





    public function exportExcel()
    {
    return Excel::download(new ProductExport, 'product.xlsx');
    }

    public function exportPdf()
    {
        $product = Product::all();

        $pdf = PDF::loadView('Product.export_pdf', compact('product'));

        return $pdf->download('product.pdf');
    }


    }

