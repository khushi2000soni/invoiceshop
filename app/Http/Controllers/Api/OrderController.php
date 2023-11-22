<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request){
        //dd($request->all());

        $validator = Validator::make($request->all(),[
            'customer_id' => ['required','integer'],
            'thaila_price' => ['nullable','numeric'],
            'is_round_off' => ['required','boolean'],
            'round_off_amount' => ['nullable','numeric'],
            'sub_total'=> ['required','numeric'],
            'grand_total' => ['required','numeric'],
            'products' => ['required','array'],
            'products.*.product_id' => ['required','exists:products,id'],
            'products.*.quantity' => ['required','integer','min:1'],
            'products.*.price' => ['required','numeric'],
            'products.*.total_price' => ['required','numeric'],
        ]);

        if($validator->fails()){
            $responseData = [
                'status'        => false,
                'validation_errors' => $validator->errors(),
            ];
            return response()->json($responseData, 401);
        }

        try {
            DB::beginTransaction();
            // Create a new order
            $order = Order::create([
                'customer_id' => (int)$request->customer_id,
                'thaila_price' => (float)$request->thaila_price,
                'is_round_off' => $request->is_round_off,
                'sub_total' => (float)$request->sub_total,
                'round_off' => (float)$request->round_off_amount,
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

            $responseData = [
                'status'        => true,
                'message' => "success",
            ];
            return response()->json($responseData, 401);

        } catch (\Exception $e) {
           //dd($e->getMessage());

            DB::rollBack();
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.error_message'),
            ];
            return response()->json($responseData, 500);
        }
    }
}
