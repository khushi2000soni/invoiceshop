<?php

namespace App\Http\Controllers;

use App\DataTables\CustomerDataTable;
use App\DataTables\PhoneBookDataTable;
use App\Http\Requests\Customer\CreateRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CustomerDataTable $dataTable)
    {
        //
        abort_if(Gate::denies('customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $addresses = Address::orderBy('id','desc')->get();
        return $dataTable->render('admin.customer.index',compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $addresses = Address::orderBy('id','asc')->get();
        $htmlView = view('admin.customer.create', compact('addresses'))->render();
        return response()->json(['success' => true, 'htmlView' => $htmlView]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $input = $request->all();
        $input['name']=ucwords($request->name);
        $input['guardian_name']=ucwords($request->guardian_name);
        $customer=Customer::create($input);
        return response()->json(['success' => true,
        'message' => trans('messages.crud.add_record'),
        'alert-type'=> trans('quickadmin.alert-type.success'),
        'title' => trans('quickadmin.customers.customer')], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::with('address')->findOrFail($id);
        $addresses = Address::all();
        $htmlView = view('admin.customer.edit', compact('addresses','customer'))->render();
        return response()->json(['success' => true, 'htmlView' => $htmlView]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Customer $customer)
    {
        $customer->update($request->all());
        return response()->json(['success' => true,
        'message' => trans('messages.crud.update_record'),
        'alert-type'=> trans('quickadmin.alert-type.success')], 200);
    }


    public function CustomerListOfAddress(string $id){

        $address = Address::where('id',$id)->first();
       // $addressname= $address->address;
        $customers = Customer::where('address_id',$id)->get();
        return view('admin.address.address-list-customer', compact('customers','address'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('customer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response()->json(['success' => true,
         'message' => trans('messages.crud.delete_record'),
         'alert-type'=> trans('quickadmin.alert-type.success'),
         'title' => trans('quickadmin.customers.customer')
        ], 200);
    }


    public function showPhoneBook(PhoneBookDataTable $dataTable){
        $addresses = Address::orderBy('id','desc')->get();
        return $dataTable->render('admin.customer.phone-book',compact('addresses'));
    }
}
