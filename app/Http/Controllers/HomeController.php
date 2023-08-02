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
        $customer_count = Customer::count();
        $product_count = Product::count();
        $transaction_count = Transaction::count();
        $profit = $transaction->sum('sub_total');
        // $totalTransaction = $transaction->count();
        $items = Transaction::with([
            'customer'
        ])->where('valid', TRUE)->get();



        return view('home', [
            'items' => $items,
            'pageTitle' => $pageTitle,
            'customer_count' => $customer_count,
            'product_count' => $product_count,
            'transaction_count' => $transaction_count,
            'profit' => $this->thousandsCurrencyFormat($profit),
        ]);
    }

    private function thousandsCurrencyFormat($num) {

        if($num>1000) {

              $x = round($num);
              $x_number_format = number_format($x);
              $x_array = explode(',', $x_number_format);
              $x_parts = array(' Rb', ' Jt', ' M', ' T');
              $x_count_parts = count($x_array) - 1;
              $x_display = $x;
              $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
              $x_display .= $x_parts[$x_count_parts - 1];

              return $x_display;

        }

        return $num;
}
}
