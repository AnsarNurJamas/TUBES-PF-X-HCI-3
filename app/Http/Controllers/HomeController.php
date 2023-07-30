<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pageTitle = 'Home';
        $transaction = Transaction::whereMonth('created_at', '=', date('m'))->where('valid', TRUE)->get();
        // $customer_count = Customer::count();
        // $product_count = Product::count();


        return view('home', ['pageTitle' => $pageTitle]);
    }
}
