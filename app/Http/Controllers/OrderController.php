<?php

namespace App\Http\Controllers;

use App\DataTables\InvoiceDataTable;
use App\Http\Requests\Order\StoreRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Exception;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(InvoiceDataTable $dataTable)
    {
        abort_if(Gate::denies('invoice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return $dataTable->render('admin.order.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('admin.order.create',compact('customers','products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create a new order
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'thaila_price' => $request->thaila_price,
                'is_round_off' => $request->is_round_off,
                'sub_total' => $request->sub_total,
                'round_off_amount' => $request->round_off_amount,
                'grand_total' => $request->grand_total,
                'invoice_date' => Carbon::now(),
            ]);

            // Generate the invoice number
            $invoiceNumber = generateInvoiceNumber($order->id);
            $order->update(['invoice_number' => $invoiceNumber]);

            // Create order products
            foreach ($request->products as $productData) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $productData['product_id'],
                    'quantity' => $productData['quantity'],
                    'price' => $productData['price'],
                    'total_price' => $productData['total_price'],
                ]);
            }

            DB::commit();

            return response()->json(['success' => true,
            'message' => trans('messages.crud.add_record'),
            'alert-type'=> trans('quickadmin.alert-type.success')], 200);

        } catch (Exception $e) {
           // dd($e->getMessage());

            DB::rollBack();
            return response()->json(['success' => false,
            'message' => trans('messages.error1'),
            'alert-type'=> trans('quickadmin.alert-type.error')], 500);
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('invoice_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $product = Order::findOrFail($id);
        $product->delete();
        return response()->json(['success' => true,
         'message' => trans('messages.crud.delete_record'),
         'alert-type'=> trans('quickadmin.alert-type.success'),
         'title' => trans('quickadmin.order.order')
        ], 200);
    }
}
