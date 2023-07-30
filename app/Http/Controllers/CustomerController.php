<?php

namespace App\Http\Controllers;


use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Exports\customerExport;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'customer';

        $customers = Customer::all();
        confirmDelete();
        return view('customer.index', [
            'pageTitle' => $pageTitle,
            'customer' => $customers
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Tambahkan Pelanggan';
        return view('customer.create', ['pageTitle' => $pageTitle]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(request $request)
    {
        $messages = [
            'required' => 'harus diisi',
            'email' => 'Isi :attribute dengan format yang benar',
        ];



        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email',
            'address' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();

        }


        $customer = New Customer;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;
        $customer->address = $request->address;
        $customer->save();

        Alert::success('Sukses Menambahkan', 'Sukses Menambahkan Pelanggan.');
        return redirect()->route('customer.index');
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
        $pageTitle = 'Edit Pelanggan';

        $customer = Customer::find($id);

        return view('customer.edit', compact('pageTitle', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'required' => 'harus diisi',
            'email' => 'Isi :attribute dengan format yang benar',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email',
            'address' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();

        }


        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;
        $customer->address = $request->address;
        $customer->save();

        // Alert::success('Sukses Mengubah', 'Sukses Mengubah Pelanggan.');
        return redirect()->route('customer.index');

}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);

        $customer->delete();

        Alert::success('Sukses Menghapus', 'Sukses Menghapus Pelanggan.');
        return redirect()->route('customer.index');
    }

    public function export1Excel()
    {
        return Excel::download(new customerExport, 'customer.xlsx',);

        // return Excel::download(new ProductExport, 'Product.xlsx');
    }

    public function exportPdf()
{
    // $customer = Customer::all();

    // $pdf = PDF::loadView('customer.export_pdf', compact('customer'));

    // return $pdf->download('customer.pdf');
}


}
