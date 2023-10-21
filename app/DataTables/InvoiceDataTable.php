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
                if (Gate::check('invoice_print')) {
                    $action = '<a type="button" class="btn btn-icon btn-info print-order-btn p-1 px-2" href="'.route('orders.edit', $order->id).'" title="'.trans('quickadmin.qa_print').'"><i class="fas fa-print"></i> </a>';
                }
                if (Gate::check('invoice_share')) {
                    $action .= '<a type="button" class="btn btn-icon btn-success share-order-btn p-1 px-2 mx-1" href="'.route('orders.edit', $order->id).'" title="'.trans('quickadmin.qa_share').'"><i class="fas fa-share"></i> </a>';
                }
                if (Gate::check('invoice_access')) {
                    $action .= '<div class="dropdown d-inline">
                    <button class="btn btn-primary dropdown-toggle px-2" type="button"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="'.trans('quickadmin.qa_view').'">
                      <i class="fas fa-align-justify"></i>
                    </button>
                    <div class="dropdown-menu">';
                        if (Gate::check('invoice_show')) {
                            $action .= '<a class="dropdown-item has-icon" href="'.route('orders.edit', $order->id).'" title="'.trans('quickadmin.qa_view').'"><i class="far fa-eye"></i> '.trans('quickadmin.qa_view').'</a>';
                        }
                        if (Gate::check('invoice_download')) {
                            $action .= ' <a class="dropdown-item has-icon" href="'.route('orders.edit', $order->id).'" title="'.trans('quickadmin.qa_download').'"><i class="fas fa-cloud-download-alt"></i> '.trans('quickadmin.qa_download').'</a>';
                        }
                        if (Gate::check('invoice_edit')) {
                            $action .= '<a class="dropdown-item has-icon" href="'.route('orders.edit', $order->id).'" title="'.trans('quickadmin.qa_edit').'"><i class="fas fa-edit"></i> '.trans('quickadmin.qa_edit').'</a>';
                        }
                        if (Gate::check('invoice_delete')) {
                        $action .= '<form action="'.route('orders.destroy', $order->id).'" method="POST" class="deleteForm m-1" id="deleteForm">
                        <a class="dropdown-item has-icon record_delete_btn" role="button" href="#"><i class="fas fa-trash"></i> '.trans('quickadmin.qa_delete').'</a></form>';
                        }
                        $action .= '</div>
                    </div>';
                }
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
