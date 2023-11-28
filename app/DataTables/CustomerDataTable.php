<?php

namespace App\DataTables;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CustomerDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */


     public function dataTable(QueryBuilder $query): EloquentDataTable
     {
         return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('name',function($customer){
                return $customer->name ?? "";
            })
            ->editColumn('guardian_name',function($customer){
                return $customer->guardian_name ?? "";
            })
            ->editColumn('phone',function($customer){
                $ph1= $customer->phone  ?? "";
                $ph2= $customer->phone2 ? ' / '.$customer->phone2 : "";
                $phone= $ph1.$ph2;
                return $phone;
            })

            ->editColumn('address',function($customer){

                $address = $customer->address;
                return $address ? $address->address : '';
            })
            ->editColumn('created_at', function ($customer) {
                return $customer->created_at->format('d-M-Y H:i A');
            })
            ->addColumn('action',function($customer){
                $action='';
                if (Gate::check('customer_edit')) {
                $action .= '<button type="button" class="btn btn-icon btn-info edit-customers-btn p-1 mx-1" data-toggle="modal" data-target="#editModal" data-id="'.encrypt($customer->id).'" data-href="'.route('customers.edit', $customer->id).'"><i class="fas fa-edit"></i></button>';
                }
                if (Gate::check('customer_delete')) {
                $action .= '<form action="'.route('customers.destroy', $customer->id).'" method="POST" class="deleteForm m-1" id="deleteForm">
                <button title="'.trans('quickadmin.qa_delete').'" class="btn btn-icon btn-danger record_delete_btn btn-sm"><i class="fas fa-trash"></i></button>
                </form>';
                }
                return $action;
            })
            ->filterColumn('address', function ($query, $keyword) {
                $query->whereHas('address', function ($q) use ($keyword) {
                    $q->where('address.address', 'like', "%$keyword%");
                });
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(customers.created_at,'%d-%M-%Y') like ?", ["%$keyword%"]); //date_format when searching using date
            })
            ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Customer $model): QueryBuilder
    {
        if(isset(request()->address_id) && request()->address_id){
            $model = $model->where('address_id', request()->address_id);
        }

        return $model->newQuery()->with('address');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
        ->setTableId('customers-table')
        ->parameters([
            'responsive' => true,
            'pageLength' => 70,
        ])
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->dom('lBfrtip')
        ->orderBy(1)
        ->selectStyleSingle()
        ->buttons([
            Button::make('excel')->exportOptions(['columns' => [0, 1, 2, 3, 4, 5]]),
            // Button::make('print')->exportOptions(['columns' => [0, 1, 2, 3, 4, 5]]),
        ]);
    }


    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title(trans('quickadmin.qa_sn'))->orderable(false)->searchable(false),
            Column::make('name')->title(trans('quickadmin.customers.fields.name')),
            Column::make('guardian_name')->title(trans('quickadmin.customers.fields.guardian_name')),
            Column::make('phone')->addClass('text-center')->title(trans('quickadmin.customers.fields.ph_num')),
            Column::make('address')->title(trans('quickadmin.customers.fields.address')),
            Column::make('created_at')->title(trans('quickadmin.customers.fields.created_at')),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-left')->title(trans('quickadmin.qa_action')),
        ];
    }


    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Customer_' . date('YmdHis');
    }
}
