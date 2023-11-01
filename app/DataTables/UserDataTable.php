<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
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
            ->editColumn('name',function($staff){
                return $staff->name ?? "";
            })
            ->editColumn('role',function($staff){
                $role = $staff->roles->first();
                return $role ? $role->name : '';
            })
            ->editColumn('username',function($staff){
                return $staff->username  ?? "";
            })
            ->editColumn('email',function($staff){
                return $staff->email  ?? "";
            })
            ->editColumn('phone',function($staff){
                return $staff->phone  ?? "";
            })
            ->editColumn('created_at', function ($staff) {
                return $staff->created_at->format('d-M-Y H:i A');
            })
            ->addColumn('action',function($staff){
                $action='';
                if (Gate::check('staff_edit')) {
                $action .= '<button type="button" class="btn btn-icon btn-info edit-users-btn p-1 mx-1" data-toggle="modal" data-target="#editModal" data-id="'.encrypt($staff->id).'" data-href="'.route('staff.edit', $staff->id).'"><i class="fas fa-edit"></i></button>';
                }
                if (Gate::check('staff_edit')) {
                $action .= '<button type="button" class="btn btn-icon btn-dark edit-password-btn p-1 " data-toggle="modal" data-target="#passwordModal" data-id="'.encrypt($staff->id).'" data-href="'.route('staff.password', $staff->id).'"><i class="fas fa-lock"></i></button>';
                }
                if (Gate::check('staff_delete')) {
                    if (!($staff->hasRole(1))) {
                $action .= '<form action="'.route('staff.destroy', $staff->id).'" method="POST" class="deleteForm m-1" id="deleteForm">
                <button title="'.trans('quickadmin.qa_delete').'" class="btn btn-icon btn-danger record_delete_btn btn-sm"><i class="fas fa-trash"></i></button>
                </form>';
                    }
                }
                return $action;
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(users.created_at,'%d-%M-%Y') like ?", ["%$keyword%"]); //date_format when searching using date
            })
            ->filterColumn('role', function ($query, $keyword) {
                $query->whereHas('roles', function ($q) use ($keyword) {
                    $q->where('roles.name', 'like', "%$keyword%");
                });
            })
            ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        $query = $model->newQuery()->select(['users.*']);
        if (!(auth()->user()->hasRole(1))) {
            $query->whereNotIn('id', [1]);
        }
        return $this->applyScopes($query);
        // return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {

        return $this->builder()
        ->setTableId('users-table')
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
            Column::make('name')->title(trans('quickadmin.users.fields.name')),
            Column::make('role')->title(trans('quickadmin.users.fields.role')),
            Column::make('username')->title(trans('quickadmin.users.fields.usernameid')),
            Column::make('email')->title(trans('quickadmin.users.fields.email')),
            Column::make('phone')->title(trans('quickadmin.users.fields.phone')),
            Column::make('created_at')->title(trans('quickadmin.users.fields.created_at')),
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
        return 'User_' . date('YmdHis');
    }
}
