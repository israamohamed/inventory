<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Expense;
use App\Models\Product;

class HomeController extends Controller
{
    public function statistics()
    {
        $data['number_of_today_orders'] = Order::where('date' , date("Y-m-d"))->count();
        $data['total_income_today']     = Order::where('date' , date("Y-m-d"))->get()->sum('total_price') ;
        $data['number_of_total_orders'] = Order::count();
        $data['today_expenses']         = Expense::where('date' , date("Y-m-d"))->sum('amount');

        return responseJson(1 , 'success' , $data );
    }

    public function products_out_of_stock()
    {
        $products = Product::where('quantity' , '<=' , 0)->get();
        return responseJson(1 , 'success' , $products);
    }
}
