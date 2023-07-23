<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
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
        $customer_count = Customer::count();
        $product_count = Product::count();


        return view('home', ['pageTitle' => $pageTitle,
        'customer_count' => $customer_count,
        'product_count' => $product_count,]);
    }
}
