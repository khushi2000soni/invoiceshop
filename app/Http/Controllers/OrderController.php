<?php

namespace App\Http\Controllers;

use App\DataTables\InvoiceDataTable;
use App\Http\Requests\Order\StoreRequest;
use App\Http\Requests\Order\UpdateRequest;
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
use Illuminate\Support\Facades\Mail;
use PDF;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(InvoiceDataTable $dataTable)
    {
        abort_if(Gate::denies('invoice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $customers = Customer::all();
        return $dataTable->render('admin.order.index',compact('customers'));
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
    {  //dd($request->all());
        try {
            DB::beginTransaction();

            // Create a new order
            $order = Order::create([
                'customer_id' => (int)$request->customer_id,
                'thaila_price' => (float)$request->thaila_price,
                'is_round_off' => $request->is_round_off,
                'sub_total' => (float)$request->sub_total,
                'round_off' => $request->round_off_amount,
                'grand_total' => (float)$request->grand_total,
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
           dd($e->getMessage());

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
        $order = Order::with('orderProduct.product')->findOrFail($id);
        $customer_id = $order->customer->id;
        $products = $order->orderProduct->map(function ($product) use ($customer_id) {
        $associatedProduct = Product::find($product->product_id);
            return [
                'order_product_id'=>$product->id,
                'customer_id' => $customer_id,
                'product_id' => $product->product_id,
                'product_name' => $associatedProduct->name,
                'quantity' => $product->quantity,
                'price' => $product->price,
                'total_price' => $product->total_price,
            ];
        })->toArray();

        $orderData = [
            'orderid' => $order->id,
            'invoice_number' => $order->invoice_number,
            'customer_id' => $customer_id,
            'products' => $products,
            'thailaPrice' => $order->thaila_price,
            'is_round_off' => $order->is_round_off,
            'sub_total' => $order->sub_total,
            'round_off_amount' => $order->round_off,
            'grand_total' => $order->grand_total,
        ];


        $products = Product::all();
        $customers = Customer::all();
        //dd($customers);
        return view('admin.order.edit',compact('order','customers','products','orderData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Order $order)
    {
       // dd($request->all());
        try {
            DB::beginTransaction();
            $order->update([
                'customer_id' => $request->customer_id,
                'thaila_price' => $request->thaila_price,
                'is_round_off' => $request->is_round_off,
                'sub_total' => $request->sub_total,
                'round_off' => $request->round_off_amount,
                'grand_total' => $request->grand_total,
            ]);

            $productsToDelete = $request->deleted_products ?? [];

            foreach ($request->products as $productData) {
                if (isset($productData['order_product_id']) && !empty($productData['order_product_id'])) {
                    // Update existing product with order_product_id
                    $existingProduct = OrderProduct::find($productData['order_product_id']);
                    if ($existingProduct) {
                        $existingProduct->update([
                            'quantity' => $productData['quantity'],
                            'product_id' => $productData['product_id'],
                            'price' => $productData['price'],
                            'total_price' => $productData['total_price'],
                        ]);
                    }
                } else {
                    // Create a new product without order_product_id
                    OrderProduct::create([
                        'order_id' => $order->id,
                        'product_id' => $productData['product_id'],
                        'quantity' => $productData['quantity'],
                        'price' => $productData['price'],
                        'total_price' => $productData['total_price'],
                    ]);
                }
            }

            if (!empty($productsToDelete)) {
                OrderProduct::whereIn('id', $productsToDelete)->delete();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => trans('messages.crud.update_record'),
                'alert-type' => trans('quickadmin.alert-type.success')
            ], 200);
        } catch (Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => trans('messages.error1'),
                'alert-type' => trans('quickadmin.alert-type.error')
            ], 500);
        }
    }


    public function generatePdf($orderId)
    {
        //dd($orderId);
        $order = Order::with('orderProduct.product')->findOrFail($orderId);
        $pdf = PDF::loadView('admin.order.pdf.invoice-pdf', compact('order'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('order_' . $order->invoice_number . '.pdf');
    }


    public function printPDF(Request $request, $order)
    {
        // Get the order data here (e.g., from the database).
        $order = Order::with('orderProduct.product')->findOrFail($order);
        $pdfFileName = 'invoice_' . $order->invoice_number . '.pdf';
        $pdf = PDF::loadView('admin.order.pdf.invoice-pdf', compact('order'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream($pdfFileName, ['Attachment' => false]);
        //return view('admin.order.pdf.invoice-pdf', compact('order'));
    }

    public function shareEmail(Request $request, $order)
    {
        // Generate the PDF (similar to the printPDF method) and send it via email.
        // You can use Laravel's built-in Mail functionality to send the email.

        // Example code for sending email (adjust to your needs):
        Mail::send('email.invoice', ['order' => $order], function ($message) use ($order) {
            $message->to($order->email)->subject('Invoice');
        });

        return redirect()->back()->with('success', 'Invoice sent via email');
    }

    public function shareWhatsApp(Request $request, $order)
    {
        // Generate the PDF (similar to the printPDF method) and provide a way to share it via WhatsApp.
        // You can open a WhatsApp web link or use a sharing package for Laravel.

        // Example code for generating a WhatsApp web link:
        $url = 'https://web.whatsapp.com/send?text=' . urlencode('Check out this invoice: ' . route('orders.generate-pdf', $order->id));
        return redirect($url);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('invoice_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(['success' => true,
         'message' => trans('messages.crud.delete_record'),
         'alert-type'=> trans('quickadmin.alert-type.success'),
         'title' => trans('quickadmin.order.invoice')
        ], 200);
    }
}
