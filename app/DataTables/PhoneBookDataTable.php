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

class PhoneBookDataTable extends DataTable
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

            ->filterColumn('address', function ($query, $keyword) {
                $query->whereHas('address', function ($q) use ($keyword) {
                    $q->where('address.address', 'like', "%$keyword%");
                });
            });

    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Customer $model): QueryBuilder
    {
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
            Column::make('name')->title(trans('quickadmin.customers.fields.name')),
            Column::make('guardian_name')->title(trans('quickadmin.customers.fields.guardian_name')),
            Column::make('phone')->title(trans('quickadmin.customers.fields.ph_num')),
            Column::make('address')->title(trans('quickadmin.customers.fields.address')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PhoneBook_' . date('YmdHis');
    }
}
