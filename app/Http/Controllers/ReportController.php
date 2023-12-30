<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Device;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{

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
        $timeFrame = $request->input('time_frame', 'monthly');
        $data = null;
        // Fetch the default data based on the default time frame
        $data = $this->getDataForTimeFrame($timeFrame);

        $totalOrderCount = Order::count();
        $totalProductCount = Product::count();
        $totalCustomerCount = Customer::count();
        $deviceCount = Device::count();

        return view('admin.report.report-category', compact(
            'data',
            'timeFrame',
            'totalOrderCount',
            'totalCustomerCount',
            'totalProductCount',
            'deviceCount'
        ));
    }


    public function fetchReportData(Request $request)
    {
        $timeFrame = $request->input('timeFrame');

        // Fetch the data for the selected time frame
        $data = $this->getDataForTimeFrame($timeFrame);

        return response()->json(['data' => $data]);
    }

    private function getDataForTimeFrame($timeFrame)
    {
        $data = null;
        switch ($timeFrame) {
            case 'today':
                $data = $this->getTodayData();
                break;
            case '7days':
                $data = $this->getLast7DaysData();
                break;
            case '30days':
                $data = $this->getLast30DaysData();
                break;
            case 'monthly':
                $data = $this->getMonthlyData();
                break;
            case 'weekly':
                $data = $this->getWeeklyData();
                break;
            default:
                $data = $this->getMonthlyData();
                break;
        }

        return $data; // Handle other cases or validation
    }

    private function getMonthlyData() {
        $currentDate = now();
        $labels = [];
        $values = [];

        // Fetch data for the last 30 days
        for ($i = 0; $i < 30; $i++) {
            $startDate = $currentDate->copy()->startOfDay();
            $endDate = $currentDate->copy()->endOfDay();

            $orders = Order::with('orderProduct.product')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            // Format data for the chart
            $labels[] = $startDate->format('d M');
            $values[] = $orders->count();
            $currentDate->subDay(); // Move back to the previous day
        }

        return ['labels' => array_reverse($labels), 'values' => array_reverse($values)];
    }

    // Method to fetch weekly data
    private function getWeeklyData() {

        $currentDate = now();
        $labels = [];
        $values = [];

        // Fetch data for the last 7 days
        for ($i = 0; $i < 7; $i++) {
            $startDate = $currentDate->copy()->startOfDay();
            $endDate = $currentDate->copy()->endOfDay();

            $orders = Order::with('orderProduct.product')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            // Format data for the chart
            $labels[] = $startDate->format('d M');
            $values[] = $orders->count();
            $currentDate->subDay(); // Move back to the previous day
        }

        return ['labels' => array_reverse($labels), 'values' => array_reverse($values)];
    }

    private function getTodayData()
    {
        // Fetch the last 7 orders of today
        $today = now()->startOfDay(); // Get the start of the current day

        $data = Order::with('customer.address')
            ->where('created_at', '>=', $today)
            ->orderBy('created_at', 'desc')
            ->get(['invoice_number', 'grand_total', 'customer_id']);

        return $data;
    }

    private function getLast7DaysData()
    {
        // Fetch the last 7 records of the last 7 days
        $last7Days = now()->subDays(7)->startOfDay(); // Calculate the start of the day 7 days ago
        $data = Order::with('customer.address')
            ->where('created_at', '>=', $last7Days)
            ->orderBy('created_at', 'desc')
            ->get(['invoice_number', 'grand_total', 'customer_id']);

        return $data;
    }

    private function getLast30DaysData()
    {
        // Fetch the last 7 records of the last 30 days
        $last30Days = now()->subDays(30)->startOfDay(); // Calculate the start of the day 30 days ago

        $data = Order::with('customer.address')
            ->where('created_at', '>=', $last30Days)
            ->orderBy('created_at', 'desc')
            ->get(['invoice_number', 'grand_total', 'customer_id']);

        return $data;
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
