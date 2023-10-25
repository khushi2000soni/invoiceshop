<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InvoiceDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query)
    {
        return datatables()
        ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('invoice_number',function($order){
                return $order->invoice_number ?? "";
            })
            ->editColumn('customer_name',function($order){
                $customer = $order->customer;
                return $customer ? $customer->name : '';
            })
            ->editColumn('grand_total',function($order){
                return $order->grand_total ?? "";
            })
            ->editColumn('created_at', function ($order) {
                return $order->created_at->format('d-M-Y H:i A');
            })
            ->addColumn('action',function($order){
                $action =view('admin.order.partials.actions',compact('order'))->render();
                return $action;
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(orders.created_at,'%d-%M-%Y') like ?", ["%$keyword%"]); //date_format when searching using date
            })
            ->filterColumn('customer_name', function ($query, $keyword) {
                $query->whereHas('customer', function ($q) use ($keyword) {
                    $q->where('customers.name', 'like', "%$keyword%");
                });
            })
            ->rawColumns(['action']);
    }
    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        return $model->newQuery()->with('customer');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {

        return $this->builder()
        ->setTableId('orders-table')
        ->parameters([
            'responsive' => true,
            'pageLength' => 70,
        ])
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->dom('lBfrtip')
        ->orderBy(1)
        // ->selectStyleSingle()
        ->buttons([
            // Button::make('excel'),
            // Button::make('csv'),
            // Button::make('pdf'),
            // Button::make('print'),
        ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title(trans('quickadmin.qa_sn'))->orderable(false)->searchable(false),
            Column::make('invoice_number')->title(trans('quickadmin.order.fields.invoice_number')),
            Column::make('customer_name')->title(trans('quickadmin.order.fields.customer_name')),
            Column::make('grand_total')->title(trans('quickadmin.order.fields.total_price')),
            Column::make('created_at')->title(trans('quickadmin.order.fields.created_at')),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center')->title(trans('quickadmin.qa_action')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Invoice_' . date('YmdHis');
    }
}
