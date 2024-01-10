<?php

namespace App\Http\Controllers;

use App\DataTables\ReportCategoryDataTable;
use App\Exports\CatgoryReportExport;
use App\Exports\CatgoryProductReportExport;
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
    public function reportCategory(ReportCategoryDataTable $dataTable)
    {
        abort_if(Gate::denies('report_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $addresses = Address::orderByRaw('CAST(address AS SIGNED), address')->get();
        // Pass the calculated data to the DataTable
        return $dataTable->render('admin.report.report-category',compact('addresses'));
    }

    public function CategoryProductReport(Request $request)
    {
        abort_if(Gate::denies('report_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $category_id = $request->category_id ;
        $from_date = $request->from_date ?? null;
        $to_date = $request->to_date ?? null;
        $category_percent = $request->category_percent ?? null;
        $category_name = Category::find($category_id)->name;
        $duration = $from_date && $to_date ? Carbon::parse($from_date)->format('d-m-Y') . ' to ' . Carbon::parse($to_date)->format('d-m-Y') : null;
        $query = Product::getFilteredProducts($request);
        $alldata = $query->get();
        $totalAmount = $alldata->sum('amount');
        $html = view('admin.report.report-category-product', compact('alldata','category_percent','totalAmount','category_name', 'duration','category_id','from_date','to_date'))->render();
        return response()->json(['success' => true, 'htmlView' => $html]);
    }


    public function getCategoryChartData(Request $request)
    {
        $query = Category::getFilteredCategories($request);
        $data =  $query->get();
        $transformedData = $data->map(function ($item) {
            return [
                'category' => $item->name,
                'amount' => $item->amount,
            ];
        });
        return response()->json($transformedData);
    }

    public function CatgoryReportPrintView(Request $request)
    {
       // dd($request->all());
        abort_if(Gate::denies('report_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $query = Category::getFilteredCategories($request);
        $catdata = $query->get();
        //dd($catdata);
        $totalAmount = $catdata->sum('amount');
        return view('admin.report.print-report-category',compact('catdata','totalAmount'))->render();
    }

    public function CatgoryReportExport(Request $request){
        abort_if(Gate::denies('report_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return Excel::download(new CatgoryReportExport($request), 'Category-Report.xlsx');
    }

    // category's product print and excel

    public function CatgoryProductReportPrintView(Request $request)
    {
       //
        abort_if(Gate::denies('report_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $category_id = $request->category_id ;
        $from_date = $request->from_date ?? null;
        $to_date = $request->to_date ?? null;
        $category_percent = $request->category_percent ?? null;
        $category_name = Category::find($category_id)->name;
        $duration = $from_date && $to_date ? Carbon::parse($from_date)->format('d-m-Y') . ' to ' . Carbon::parse($to_date)->format('d-m-Y') : null;
        $query = Product::getFilteredProducts($request);
        $alldata = $query->get();
        $totalAmount = $alldata->sum('amount');
        return view('admin.report.print-report-category-product',compact('alldata','category_percent','totalAmount','category_name', 'duration'))->render();
    }

    public function CatgoryProductReportExport(Request $request){
        //dd($request->all());
        abort_if(Gate::denies('report_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return Excel::download(new CatgoryProductReportExport($request), 'Category-Product-Report.xlsx');
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
