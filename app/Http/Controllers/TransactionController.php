<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PDF;
use App\Models\Sale;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Exports\TransactionExport;
use App\Models\CompanyProfile;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Transaction List";

        $items = Transaction::with([
            'customer'
        ])->where('valid', TRUE)->get();

        return view('transaction.index', [
            'title' => $title,
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($transactionCode)
    {
        if (is_null($transactionCode)) {
             abort(404);
        }

        $title = "Create Transaction";

        $sales = Sale::with([
            'product'
        ])->where('transaction_code', $transactionCode);
        $items = $sales->get();
        $subTotal = $sales->sum('total_price');

        $customers = Customer::all();

        return view('transaction.create', [
            'title' => $title,
            'transactionCode' => $transactionCode,
            'items' => $items,
            'customers' => $customers,
            'subTotal' => $subTotal
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => 'Kolom Ini Harus Diisi.',
            'numeric' => 'Format Angka',
        ];

        $validator = Validator::make($request->all(), [
            'sub_total' => 'required',
            'paid' => 'required|numeric',
            'change' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();


        }

        $request = $request->all();

        $data['user_id'] = Auth::user()->id;
        $data['customer_id'] = $request['customer_id'];
        $data['sub_total'] = str_replace(',', '', $request['sub_total']);
        $data['paid'] = str_replace(',', '', $request['paid']);
        $data['change'] = str_replace(',', '', $request['change']);
        $data['valid'] = TRUE;

        $transactionCode = now()->format('dmyHis') . Transaction::all()->count() . Auth::user()->id;

        // $pdf = PDF::loadView('transaction.nota', compact('data'));

        Transaction::where('transaction_code', $request['transaction_code'])
            ->update($data);
        return redirect()->route('transaction.create', $transactionCode)->with(['success' => 'Transaksi berhasil disimpan!', 'transactionCode' => $request['transaction_code']]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($transactionCode)
    {
        $title = "Transaction";

        $sales = Sale::with([
            'product'
        ])->where('transaction_code', $transactionCode);
        $items = $sales->get();
        $subTotal = $sales->sum('total_price');

        $customers = Customer::all();

        $transaction = Transaction::with([
            'customer',
            'user'
        ])
            ->where('transaction_code', $transactionCode)
            ->where('valid', TRUE)
            ->first();

        $user = User::findOrFail($transaction['user_id'])->name;

        $data = [
            'date' => $transaction->created_at->toDateTimeString(),
            'customerId' => $transaction->customer_id,
            'paid' => $transaction->paid,
            'change' => $transaction->change,
            'user' => $user
        ];

        return view('transaction.show', [
            'title' => $title,
            'transactionCode' => $transactionCode,
            'items' => $items,
            'customers' => $customers,
            'subTotal' => $subTotal,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    /**
     * Show a transaction report by date in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportPdfTransaction()
    {
        $items = Transaction::with([
            'customer'
        ])->where('valid', TRUE)->get();

        $pdf = PDF::loadView('transaction.export_pdf', compact('items'));

        return $pdf->download('Report_Transaction.pdf');
    }

    public function exportExcelTransaction()
    {
    return Excel::download(new TransactionExport, 'Report_Transaksi.xlsx');
    }

}

