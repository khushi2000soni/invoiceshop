<?php

namespace App\Http\Controllers;

use App\DataTables\CustomerDataTable;
use App\DataTables\PhoneBookDataTable;
use App\Exports\CustomerExport;
use App\Exports\PhoneBookExport;
use App\Http\Requests\Customer\CreateRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CustomerDataTable $dataTable)
    {
        //
        abort_if(Gate::denies('customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $addresses = Address::orderByRaw('CAST(address AS SIGNED), address')->get();
        return $dataTable->render('admin.customer.index',compact('addresses'));
    }

    public function printView($address_id = null)
    {
        //dd('test');
        abort_if(Gate::denies('customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query = Customer::query();
        if ($address_id !== null) {
            $query->where('address_id', $address_id);
        }

        $customers = $query->orderBy('id','desc')->get();
        return view('admin.customer.print-customer-list',compact('customers'))->render();
    }

    public function export($address_id = null){
        return Excel::download(new CustomerExport($address_id), 'parties.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $addresses = Address::orderByRaw('CAST(address AS SIGNED), address')->get();
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
        'title' => trans('quickadmin.customers.customer'),
        'selectdata' => [
            'id' => $customer->id,
            'name' => $customer->name,
            'formtype' => 'customer',
        ],
        ], 200);
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
        // $addresses = Address::all();
        $addresses =   Address::orderByRaw('CAST(address AS SIGNED), address')->get();
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

    //***************************Phone-Book Methods************************************** */

    public function showPhoneBook(PhoneBookDataTable $dataTable){
        $addresses = Address::orderBy('id','desc')->get();
        return $dataTable->render('admin.customer.phone-book',compact('addresses'));
    }
    public function PhoneBookprintView($address_id = null)
    {
        //dd('test');
        abort_if(Gate::denies('customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query = Customer::query();
        if ($address_id !== null) {
            $query->where('address_id', $address_id);
        }

        $customers = $query->orderBy('name','asc')->get();
        return view('admin.customer.print-phone-book',compact('customers'))->render();
    }

    public function PhoneBookexport($address_id = null){
        return Excel::download(new PhoneBookExport($address_id), 'phone-book.xlsx');
    }
}
