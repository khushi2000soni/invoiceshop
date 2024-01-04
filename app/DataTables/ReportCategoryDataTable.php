<?php

namespace App\DataTables;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReportCategoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */

    public function dataTable(QueryBuilder $query)
    {
        $totalAmount = $query->sum('amount');
        return datatables()
        ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('name', function ($data) {
                // Show the category name
                return $data->name;
            })
            ->editColumn('amount',function($data){
                return $data->amount;
            })
            // ->editColumn('total_amount', function () use ($totalAmount) {
            //     return $totalAmount;
            // })
            ->editColumn('percent_share', function ($data) use ($totalAmount) {
                if ($totalAmount == 0) {
                    return '0.00%';
                }

                $percentShare = ($data->amount / $totalAmount) * 100;
                return number_format($percentShare, 2) . '%';
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Category $model): QueryBuilder
    {
        $query = $model->newQuery();
        $query = $query->select([
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

        if (request()->has('address_id')) {
            //dd(request()->address_id);
            $addressId = request()->address_id;
            $query->where('customers.address_id', $addressId);
        }

        if (request()->has('from_date')) {
            //dd(request()->from_date ,request()->to_date );
            $fromDate = Carbon::parse(request()->from_date)->startOfDay();
            $query->where('order_products.created_at', '>=', $fromDate);
        }

        if (request()->has('to_date')) {
            $toDate = Carbon::parse(request()->to_date)->endOfDay();
            $query->where('order_products.created_at', '<=', $toDate);
        }

        //dd($query->toSql());

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('categories-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('rtip')
                    ->orderBy(1);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title(trans('quickadmin.qa_sn'))->orderable(false)->searchable(false),
            Column::make('name')->title(trans('quickadmin.qa_category_name'))->orderable(false)->searchable(false),
            Column::make('amount')->title(trans('quickadmin.reports.sale_amount'))->addClass('text-center')->orderable(false)->searchable(false),
            // Column::make('total_amount')->title(trans('quickadmin.reports.total_amount'))->addClass('text-center')->orderable(false)->searchable(false),
            Column::make('percent_share')->title(trans('quickadmin.reports.sale_percent'))->addClass('text-center')->orderable(false)->searchable(false),
        ];
    }
    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ReportCategory_' . date('YmdHis');
    }
}
