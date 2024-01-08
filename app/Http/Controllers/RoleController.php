<?php

namespace App\Http\Controllers;

//use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\DataTables\RoleDataTable;
use App\Rules\TitleValidationRule;
//use App\Models\Permission;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */

    public function index(RoleDataTable $dataTable)
    {
        //
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //$roles = Role::orderBy('id','asc')->get();

       // return view('admin.roles.index', compact('roles'));
        return $dataTable->render('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $permissions = Permission::select('id','route_name', 'name')->get()->groupBy('route_name');
        return view('admin.roles.create', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData =$request->validate([
            'name' => ['required','string','unique:roles,name', new TitleValidationRule],
            'permissions'=> '',
        ],[
            'name.regex'=> 'The title should not contain multiple consecutive spaces or consist of only spaces.'
        ]);
        $validatedData['guard_name']='web';
        $permissionIds = $request->input('permissions');
        $role=Role::create($validatedData);
        if (!empty($permissionIds)) {
            $role->givePermissionTo($permissionIds);
        }

        return response()->json(['success' => true, 'message' => trans('messages.crud.add_record'),'alert-type'=> trans('quickadmin.alert-type.success')], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::find($id);
        $permissions = $role->permissions;
        $groupedPermissions = $permissions->groupBy('route_name');
        //dd($groupedPermissions);
        return view('admin.roles.show', compact('role','groupedPermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $role = Role::find($id);
        $permissions = Permission::select('id', 'route_name', 'name')->get()->groupBy('route_name');
        $selectedPermissions = $role->getAllPermissions();
        return view('admin.roles.edit', compact('role','permissions','selectedPermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::find($id);
        $validatedData = $request->validate([
            'name' => ['required','string','unique:roles,name,'.$role->id, new TitleValidationRule],
            'permissions' => 'array',
        ]);
        try {
            DB::beginTransaction();
            $permissionsToAssign = $request->input('permissions', []);
            // dd($permissionsToAssign);
            $role->update($validatedData);
            // $role->givePermissionTo($permissionsToAssign);
            $role->syncPermissions($permissionsToAssign);
            DB::commit();
         } catch (\Exception $e) {
            //dd($e->getMessage());
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => trans('messages.error1'),
                'alert-type' => trans('quickadmin.alert-type.error')
            ], 500);
        }


     return response()->json([
        'success' => true,
        'message' => trans('messages.crud.update_record'),
        'alert-type'=> trans('quickadmin.alert-type.success'),
        'redirecturl'=>route('roles.index'),
        'title' => trans('quickadmin.roles.role')], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
