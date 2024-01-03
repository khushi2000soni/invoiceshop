<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Device;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{



    public function reportInvoice(Request $request)
    {
        abort_if(Gate::denies('report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $timeFrame = $request->input('time_frame', 'monthly');
        $data = null;
        // Fetch the default data based on the default time frame
        $data = $this->getDataForTimeFrame($timeFrame);

        $totalOrderCount = Order::count();
        $totalProductCount = Product::count();
        $totalCustomerCount = Customer::count();
        $deviceCount = Device::count();

        return view('admin.report.report-invoice', compact(
            'data',
            'timeFrame',
            'totalOrderCount',
            'totalCustomerCount',
            'totalProductCount',
            'deviceCount'
        ));
    }

    public function reportCategory(Request $request)
    {
        abort_if(Gate::denies('report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $addresses = Address::orderByRaw('CAST(address AS SIGNED), address')->get();
        return view('admin.report.report-category', compact('addresses'));
    }



    ///// old report code

    public function index(Request $request)
    {
        abort_if(Gate::denies('report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeFrame = $request->input('time_frame', 'monthly');
        $data = null;
        // Fetch the default data based on the default time frame
        $data = $this->getDataForTimeFrame($timeFrame);

        $totalOrderCount = Order::count();
        $totalProductCount = Product::count();
        $totalCustomerCount = Customer::count();
        $deviceCount = Device::count();

        return view('admin.report.index', compact(
            'data',
            'timeFrame',
            'totalOrderCount',
            'totalCustomerCount',
            'totalProductCount',
            'deviceCount'
        ));
    }

    /// product table in report code
    public function getSoldProducts(Request $request)
    {
        $timeFrame = $request->input('timeFrame');
        $soldProducts = $this->getSoldProductsForTimeFrame($timeFrame);

        return response()->json(['data' => $soldProducts]);
    }

    private function getSoldProductsForTimeFrame($timeFrame)
    {
        // SELECT products.name,SUM(order_products.quantity) AS total_sold_units,SUM(order_products.total_price) AS total_price FROM products INNER JOIN order_products ON products.id=order_products.product_id WHERE order_products.deleted_at IS NULL GROUP BY order_products.product_id;

        $soldProducts= Product::select('products.name')
        ->selectRaw('SUM(order_products.quantity) AS total_sold_units')
        ->selectRaw('SUM(order_products.total_price) AS total_price')
        ->join('order_products', 'products.id', '=', 'order_products.product_id')
        ->where('order_products.created_at', '>=', now()->subDays($this->getDaysForTimeFrame($timeFrame)))
        ->whereNull('order_products.deleted_at')
        ->groupBy('order_products.product_id')
        ->get();

        return $soldProducts;
    }

    private function getDaysForTimeFrame($timeFrame)
    {
        switch ($timeFrame) {
            case 'today':
                return 1;
            case '7days':
                return 7;
            case '30days':
                return 30;
            default:
                return 1;
        }
    }


}
