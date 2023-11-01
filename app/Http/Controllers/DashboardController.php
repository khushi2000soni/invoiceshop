<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Device;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){

        $todaySaleAmount = Order::whereDate('invoice_date', Carbon::today())->sum('grand_total');
        $last7DaysSaleAmount = Order::whereDate('invoice_date', '>=', Carbon::today()->subDays(7))->sum('grand_total');
        $last30DaysSaleAmount = Order::whereDate('invoice_date', '>=', Carbon::today()->subDays(30))->sum('grand_total');
        $allSaleAmount =  Order::sum('grand_total');
        $todayTotalOrder =  Order::whereDate('invoice_date', Carbon::today())->count();
        $totalProductInStock =  Product::count();
        $totalCategory = Category::count();
        $totalCustomer = Customer::count();

        return view('admin.dashboard', compact(
            'todaySaleAmount',
            'last7DaysSaleAmount',
            'last30DaysSaleAmount',
            'allSaleAmount',
            'todayTotalOrder',
            'totalProductInStock',
            'totalCategory',
            'totalCustomer'
        ));
    }
}
