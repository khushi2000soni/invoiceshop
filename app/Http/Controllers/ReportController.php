<?php

namespace App\Http\Controllers;

use App\DataTables\ReportCategoryDataTable;
use App\DataTables\ReportCategoryProductDataTable;
use App\Exports\CatgoryReportExport;
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
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    // Category Report Methods Starts
    public function reportCategory(ReportCategoryDataTable $dataTable)
    {
        abort_if(Gate::denies('report_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $addresses = Address::orderByRaw('CAST(address AS SIGNED), address')->get();
        // Pass the calculated data to the DataTable
        return $dataTable->render('admin.report.report-category',compact('addresses'));

    }

    public function CategoryProductReport(ReportCategoryProductDataTable $dataTable)
    {
        abort_if(Gate::denies('report_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //return $dataTable->render('admin.report.report-category-product');
        // Get the category ID and other filter parameters from the request
        $category_id = request('category_id');
        $address_id = request('address_id');
        $from_date = request('from_date');
        $to_date = request('to_date');

        //dd($category_id);
        // Assuming you have a method to get the category name based on the category ID
        $category_name = Category::find($category_id)->name;
        // Assuming you have a method to get the address name based on the address ID
        $address_name = $address_id ? Address::find($address_id)->address : null;
        // Prepare the duration string
        $duration = $from_date && $to_date ? Carbon::parse($from_date)->format('Y-m-d') . ' to ' . Carbon::parse($to_date)->format('Y-m-d') : null;

        // Pass the variables to the view
        return $dataTable->render('admin.report.report-category-product',compact('category_name','address_name','duration'));

    }

    public function getCategoryChartData(Request $request)
    {
        $query = Category::getFilteredCategories($request);
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

    public function CatgoryReportPrintView(Request $request)
    {
        abort_if(Gate::denies('report_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $query = Category::getFilteredCategories($request);
        $catdata = $query->get();
       // dd($catdata);
        $totalAmount = $catdata->sum('amount');
        return view('admin.report.print-report-category',compact('catdata','totalAmount'))->render();
    }

    public function CatgoryReportExport(Request $request){
        abort_if(Gate::denies('report_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return Excel::download(new CatgoryReportExport($request), 'Category-Report.xlsx');
    }


    // Invoice Report Methods Starts
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
