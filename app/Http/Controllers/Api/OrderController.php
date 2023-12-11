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
        $validator = Validator::make($request->all(),[
            'customer_id'       => ['required','integer'],
            'thaila_price'      => ['nullable','numeric'],
            'is_round_off'      => ['required','boolean'],
            'round_off'  => ['nullable','numeric'],
            'sub_total'         => ['required','numeric'],
            'grand_total'       => ['required','numeric'],
            'products'                  => ['required','array'],
            'products.*.product_id'     => ['required','exists:products,id'],
            'products.*.quantity'       => ['required','integer','min:1'],
            'products.*.price'          => ['required','numeric'],
            'products.*.total_price'    => ['required','numeric'],
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
                $orderRequest = $request->except('products');
                $orderRequest['invoice_date'] = Carbon::now();
                $order = Order::create($orderRequest);

                // Generate the invoice number
                $invoiceNumber = generateInvoiceNumber($order->id);
                $order->update(['invoice_number' => $invoiceNumber]);

                // Create order products
                $productItem = $request->products;
                $order->orderProduct()->createMany($productItem);
            DB::commit();

            $responseData = [
                'status'        => true,
                'message' => "Success",
            ];
            return response()->json($responseData, 200);

        } catch (\Exception $e) {

            DB::rollBack();
            $responseData = [
                'status'        => false,
                'error'         => $e->getMessage(),
            ];
            return response()->json($responseData, 500);
        }
    }


    public function storeOld(Request $request){
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
                'message' => "Success",
            ];
            return response()->json($responseData, 200);

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

    public function updateWng(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'customer_id'       => ['required','integer'],
            'thaila_price'      => ['nullable','numeric'],
            'is_round_off'      => ['required','boolean'],
            'round_off'  => ['nullable','numeric'],
            'sub_total'         => ['required','numeric'],
            'grand_total'       => ['required','numeric'],
            'products'                  => ['required','array'],
            'products.*.product_id'     => ['required','exists:products,id'],
            'products.*.quantity'       => ['required','integer','min:1'],
            'products.*.price'          => ['required','numeric'],
            'products.*.total_price'    => ['required','numeric'],
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
                // Update order
                $orderDetails =  Order::find($id);
                $orderData = $request->except('products');
                $orderDetails->fill($orderData);
                $orderDetails->save();

                // Create order products
                $productItem = $request->products;
                // $order->orderProduct()->createMany($productItem);
                foreach ($productItem as $item) {
                    if(isset($item['id'])){
                        $orderDetails->orderProduct()->updateOrCreate(
                            ['id' => $item['id']], // Use appropriate condition to identify the product
                            [
                                'product_id' => $item['product_id'],
                                'quantity' => $item['quantity'],
                                'price' => $item['price'],
                                'total_price' => $item['total_price'],
                            ]
                        );
                    }else{
                        $productsar['products'] = $item;
                        $orderDetails->orderProduct()->createMany($productsar);
                    }
                }
            DB::commit();
            $responseData = [
                'status'        => true,
                'message' => "Success",
            ];
            return response()->json($responseData, 200);

        } catch (\Exception $e) {

            DB::rollBack();
            $responseData = [
                'status'        => false,
                'error'         => $e->getMessage(),
            ];
            return response()->json($responseData, 500);
        }
    }

    public function update(Request $request, Order $order)
    {
       //dd($request->all());
       $validator = Validator::make($request->all(),[
        'customer_id' => ['required','integer'],
        'thaila_price' => ['nullable','numeric'],
        'is_round_off' => ['required','boolean'],
        'round_off' => ['nullable','numeric'],
        'sub_total'=> ['required','numeric'],
        'grand_total' => ['required','numeric'],
        'products' => ['required','array'],
        // 'products.*.order_product_id' => ['required','exists:order_products,id'],
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
            $order->update([
                'customer_id' => $request->customer_id,
                'thaila_price' => $request->thaila_price,
                'round_off' => $request->round_off,
                'is_round_off' => $request->is_round_off,
                'sub_total' => $request->sub_total,
                'round_off' => $request->round_off_amount,
                'grand_total' => $request->grand_total,
            ]);

            $existingOrderProductIds = $order->orderProduct->pluck('id')->toArray();
            $updatedOrderProductIds = collect($request->products)->pluck('id')->toArray();
            $deletedOrderProductIds = array_diff($existingOrderProductIds, $updatedOrderProductIds); // it will return the ids from 1st array that is not present the 2nd array

            //dd($existingOrderProductIds , $updatedOrderProductIds, $deletedOrderProductIds);

            OrderProduct::whereIn('id', $deletedOrderProductIds)->delete();   // Delete existing order products that are not in the updated list

            // Update or create order products
            foreach ($request->products as $productData) {
                $productId = $productData['id'] ?? null;
                OrderProduct::updateOrCreate(
                    ['id' => $productId],
                    [
                        'order_id' => $order->id,
                        'product_id' => $productData['product_id'],
                        'quantity' => $productData['quantity'],
                        'price' => $productData['price'],
                        'total_price' => $productData['total_price'],
                    ]
                );
            }

            DB::commit();

            $responseData = [
                'status'        => true,
                'message' => "Success",
            ];
            return response()->json($responseData, 200);

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

    public function destroy(Order $order)
    {
        //dd($order);
        if (!$order) {
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.order_not_found'),
            ];
            return response()->json($responseData, 404);
        }

        try {
            DB::beginTransaction();
            $order->delete();
            DB::commit();

            $responseData = [
                'status'        => true,
                'message' => "Success",
            ];
            return response()->json($responseData, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.error_message'),
            ];
            return response()->json($responseData, 500);
        }
    }
}
