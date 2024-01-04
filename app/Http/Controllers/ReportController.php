<?php

namespace App\Http\Controllers;

use App\DataTables\ReportCategoryDataTable;
use App\Models\Customer;
use App\Models\Device;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Address;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{

    public function reportCategory(ReportCategoryDataTable $dataTable)
    {
        abort_if(Gate::denies('report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $addresses = Address::orderByRaw('CAST(address AS SIGNED), address')->get();
        // Pass the calculated data to the DataTable
        return $dataTable->render('admin.report.report-category',compact('addresses'));

    }

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


    public function getCategoryChartData(Request $request)
    {
        $address_id = $request->address_id ?? null;
        $from_date = $request->from_date ?? null;
        $to_date = $request->to_date ?? null;
        $query = Category::query();
        $query->select([
            'categories.id as category_id',
            'categories.name as name',
            DB::raw('SUM(order_products.total_price) as amount'),
        ])
        ->leftJoin('products', 'categories.id', '=', 'products.category_id')
        ->leftJoin('order_products', 'products.id', '=', 'order_products.product_id')
        ->leftJoin('orders', 'order_products.order_id', '=', 'orders.id')
        ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
        ->whereNull('orders.deleted_at')
        ->whereNull('order_products.deleted_at')
        ->groupBy('categories.id')
        ->havingRaw('amount > 0')
        ->orderByDesc('categories.id')
        ->orderByDesc('order_products.id');

        if ($address_id) {
            $query->where('customers.address_id', $address_id);
        }

        if ($from_date !== null && $from_date != 'null') {
            $fromDate = Carbon::parse($from_date)->startOfDay();
            $query->where('order_products.created_at', '>=', $fromDate);
        }
        if ($to_date !== null && $to_date != 'null') {
            $toDate = Carbon::parse($to_date)->endOfDay();
            $query->where('order_products.created_at', '<=', $toDate);
        }

        $data =  $query->get();

        // Transform the data to the required format
        $transformedData = $data->map(function ($item) {
            return [
                'category' => $item->name,
                'amount' => $item->amount,
            ];
        });
        //dd($data);
        return response()->json($transformedData);
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
