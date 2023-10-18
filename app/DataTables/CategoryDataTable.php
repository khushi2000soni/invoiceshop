<?php

namespace App\DataTables;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
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
            ->editColumn('name',function($category){
                return $category->name ?? "";
            })
            ->editColumn('created_at', function ($category) {
                return $category->created_at->format('d-M-Y H:i A');
            })
            ->addColumn('action',function($category){

                if (Gate::check('category_edit')) {
                $action = '<button type="button" class="btn btn-outline-info edit-category-btn" data-toggle="modal" data-target="#editCategoryModal" data-id="'.encrypt($category->id).'" data-name="'. $category->name .'">'.trans('quickadmin.qa_edit').'</button>';
            }
                if (Gate::check('category_delete')) {
                $action .= '<form action="'.route('categories.destroy', $category->id).'" method="POST" class="deleteCategoryForm m-1" id="deleteCategoryForm">

                <button title="'.trans('quickadmin.qa_delete').'" class="btn btn-outline-danger record_delete_btn btn-sm">'.trans('quickadmin.qa_delete').'</button>
            </form>';
                }
                return $action;
            })->rawColumns(['action']);
    }
    /**
     * Get the query source of dataTable.
     */
    public function query(Category $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
        ->setTableId('categories-table')
        ->parameters([
            'responsive' => true,
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
            Column::make('name')->title(trans('quickadmin.category.fields.name')),
            Column::make('created_at')->title(trans('quickadmin.category.fields.created_at')),
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
        return 'Category_' . date('YmdHis');
    }
}
