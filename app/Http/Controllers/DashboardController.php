<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Device;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){

        $totalOrderCount = Order::count();
        $totalProductCount = Product::count();
        $totalCustomerCount = Customer::count();
        $deviceCount = Device::count();

        return view('admin.dashboard',compact('totalOrderCount','totalCustomerCount','totalProductCount','deviceCount'));
    }


}
