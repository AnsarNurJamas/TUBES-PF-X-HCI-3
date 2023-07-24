<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

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
            'first_name' => 'required',
            'email' => 'email',
            'address' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();

        }


        $avatar_path = '';

        if ($request->hasFile('avatar')) {
            $avatar_path = $request->file('avatar')->store('customers', 'public');
        }

        $customer = New Customer;
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->avatar = $avatar_path;
        $customer->user_id = $request->user()->id;
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
            'first_name' => 'required',
            'email' => 'email',
            'address' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();

        }


        $customer = Customer::find($id);
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if (Storage::disk('public')->exists($customer->avatar)) {
                Storage::disk('public')->delete($customer->avatar);
            }
            // Store avatar
            $avatar_path = $request->file('avatar')->store('customers', 'public');
            // Save to Database
            $customer->avatar = $avatar_path;
        }
        $customer->save();

        Alert::success('Sukses Mengubah', 'Sukses Mengubah Pelanggan.');
        return redirect()->route('customer.index');

}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);

        if (Storage::disk('public')->exists($customer->avatar)) {
            Storage::disk('public')->delete($customer->avatar);
        }

        $customer->delete();

        Alert::success('Sukses Menghapus', 'Sukses Menghapus Pelanggan.');
        return redirect()->route('customer.index');
    }

}
