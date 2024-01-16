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
    public $paramValue = null;
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
                $invoice_number= $order->invoice_number ?? "";
                $invnum = '<a class="" href="'.route('orders.edit', $order->id).'" title="'.trans('quickadmin.qa_edit').'">'.$invoice_number.'</a>';

                return $invnum;
            })
            ->editColumn('customer.name',function($order){
                $customer = $order->customer;
                return $customer ? $customer->full_name : '';
            })
            ->editColumn('created_at', function ($order) {
                return $order->created_at->format('d-m-Y h:s A');
            })
            ->editColumn('grand_total',function($order){
                return $order->grand_total ?? "";
            })
            ->addColumn('action',function($order){
                $action =view('admin.order.partials.actions',compact('order'))->render();
                return $action;
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(orders.created_at,'%d-%M-%Y') like ?", ["%$keyword%"]); //date_format when searching using date
            })
            // ->filterColumn('customer_name', function ($query, $keyword) {
            //     $query->whereHas('customer', function ($q) use ($keyword) {
            //         $q->where('customers.name', 'like', "%$keyword%");
            //     });
            // })
            ->rawColumns(['action','invoice_number']);
    }
    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        if(isset(request()->customer_id) && request()->customer_id){
            $model = $model->where('customer_id', request()->customer_id);
        }

        if(isset(request()->from_date) && request()->from_date){
            $model = $model->whereDate('invoice_date','>=', request()->from_date);
        }
        if(isset(request()->to_date) && request()->to_date){
            $model = $model->whereDate('invoice_date','<=', request()->to_date);
        }

        if (auth()->user()->hasRole([config('app.roleid.admin'), config('app.roleid.accountant')])) {
            $days = getSetting('invoice_allow_day_admin_accountant');
            $model = $model->whereDate('invoice_date', '>=', now()->subDays($days));
        }

        return $model->newQuery()->with('customer')->orderBy('updated_at','desc');
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
            'lengthMenu' => [[10, 25, 50, 70, 100, -1], [10, 25, 50, 70, 100, 'All']],
            'initComplete' => 'function(settings, json) {
                // Hide the loader on initial draw
                $(".loader").hide();
            }',
            'drawCallback' => 'function() {
                // Show and hide the loader on every draw (including page changes)
                $(".loader").show();
                setTimeout(function() {
                    $(".loader").hide();
                }, 1000);
            }',
        ])
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->dom('lfrtip')
        ->orderBy(1);
        // ->selectStyleSingle()
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns()
    {
        return [
                Column::make('DT_RowIndex')->title(trans('quickadmin.qa_sn'))->orderable(false)->searchable(false),
                Column::make('invoice_number')->title(trans('quickadmin.order.fields.invoice_number')),
                Column::make('customer.name')->title(trans('quickadmin.order.fields.customer_name')),
                Column::make('created_at')->title(trans('quickadmin.order.fields.created_at')),
                Column::make('grand_total')->title(trans('quickadmin.order.fields.total_price')),
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
