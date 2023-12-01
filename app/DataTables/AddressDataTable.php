<?php

namespace App\DataTables;

use App\Models\Address;
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

class AddressDataTable extends DataTable
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
            ->editColumn('address', function ($address) {
                $customerCount = $address->customers->count();
                if ($customerCount > 0) {
                    // If customers exist, use accordion functionality
                    return '<button class="btn btn-link toggle-accordion" type="button" title="' . $customerCount . ' '. trans('quickadmin.qa_record_found').'" data-address-id="' . $address->id . '" data-target="#customers_' . $address->id . '">' . $address->address . '</button>';
                } else {
                    // If no customers, display a simple button with title
                    return '<button class="btn" type="button" title="'.trans('quickadmin.qa_no_record').'">' . $address->address . '</button>';
                }
            })
            ->editColumn('no_of_customer', function ($address) {
                return $address->customers->count() ?? 0;
            })
            ->editColumn('created_at', function ($address) {
                return $address->created_at->format('d-M-Y H:i A');
            })
            ->addColumn('action',function($address){
                $action='';
                if (Gate::check('address_edit')) {
                $action .= '<button type="button" class="btn edit-address-btn" data-toggle="modal" data-target="#editAddressModal" data-id="'.encrypt($address->id).'" data-address="'. $address->address .'" data-href="'.route('address.edit', $address->id).'"><i class="fas fa-edit"></i></button>';
            }
                if (Gate::check('address_delete')) {
                $action .= '<form action="'.route('address.destroy', $address->id).'" method="POST" class="deleteAddressForm m-1" id="deleteAddressForm">

                <button title="'.trans('quickadmin.qa_delete').'" class="btn  record_delete_btn btn-sm"><i class="fas fa-trash"></i></button>
            </form>';
                }
                return $action;
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(address.created_at,'%d-%M-%Y') like ?", ["%$keyword%"]); //date_format when searching using date
            })
            ->rawColumns(['action','address', 'customersTable']);
    }


    /**
     * Get the query source of dataTable.
     */
    public function query(Address $model): QueryBuilder
    {
        if(isset(request()->address_id) && request()->address_id){
            $model = $model->where('id', request()->address_id);
        }

        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
        ->setTableId('address-table')
        ->parameters([
            'responsive' => true,
            'pageLength' => 70,
            'lengthMenu' => [[10, 25, 50, 70, 100, -1], [10, 25, 50, 70, 100, 'All']],
        ])
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->dom('lBfrtip')
        ->orderBy(1)
        // ->selectStyleSingle()
        ->buttons([
            Button::make('excel')->exportOptions(['columns' => [0, 1, 2,3]]),
            Button::make('print')->exportOptions(['columns' => [0, 1, 2,3]]),
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
            Column::make('address')->title(trans('quickadmin.address.fields.list.address')),
            Column::make('no_of_customer')->title(trans('quickadmin.address.fields.list.no_of_customer')),
            Column::make('created_at')->title(trans('quickadmin.address.fields.list.created_at')),
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
        return 'Address_' . date('YmdHis');
    }
}
