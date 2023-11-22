<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CustomerController extends Controller
{
    public function PartyInvoiceList(){

        //$user= auth()->user();
        //$guardName = auth()->user()->guard_name;
        //$user = auth()->guard('sanctum')->user();
        //dd($user);
        // if (!$user->hasPermissionTo('customer_access')) {
        //     abort(403, 'Forbidden');
        // }
        // $permissions = $user->getAllPermissions();
        // dd($permissions);
        //abort_if(Gate::denies('customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try{
            $today = Carbon::today();
            $orders = Order::with('customer.address')->whereDate('created_at', $today)->get();
            //dd($orders);
            if($orders){
                $responseData = [
                    'status'    => true,
                    'message'   => 'success',
                    'userData'  => [],
                ];
                foreach ($orders as $order) {
                    $responseData['userData'][] = [
                        'order_id'           => $order->id ?? '',
                        'invoice_number'     => $order->invoice_number ?? '',
                        'grand_total'        => $order->grand_total ?? '',
                        'invoice_date'       => $order->invoice_date ?? '',
                        'customer_id'        => $order->customer_id ?? '',
                        'customer_name'   => $order->customer ? $order->customer->name : '',
                        'customer_email'   => $order->customer ? $order->customer->email : '',
                        'customer_phone1'   => $order->customer ? $order->customer->phone : '',
                        'customer_phone2'   => $order->customer ? $order->customer->phone2 : '',
                        'customer_address'   => $order->customer->address ? $order->customer->address->address : '',
                    ];
                }

                return response()->json($responseData, 200);
            }

            $responseData = [
                'status'            => true,
                'message'           => 'No Record for Today!',
            ];
            return response()->json($responseData, 200);

        }catch (\Exception $e) {
            dd($e->getMessage().'->'.$e->getLine());
            //Return Error Response
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.error_message'),
            ];
            return response()->json($responseData, 401);
        }

    }

    public function PartyOrderDetail(Request $request){
        //dd($request->all());
        //abort_if(Gate::denies('customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $customer = Customer::find($request->customer_id);
        if (!$customer) {
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.invalid_customer'),
            ];
            return response()->json($responseData, 401);
        }
        try{

            $today = Carbon::today();
            //$orders = Order::with('customer')->whereDate('created_at', $today)->where(['id'=>$request->order_id,'customer_id'=>$request->customer_id])->get();
            $orders = Order::with(['customer.address', 'orderProduct.product'])->whereDate('created_at', $today)
            ->where('customer_id', $request->customer_id)
            ->get();

            //dd($orders);
            if ($orders->isNotEmpty()) {
                $responseData = [
                    'status' => true,
                    'message' => 'success',
                    'customerData' => [
                        'customer_id'        => $customer->id ?? '',
                        'customer_name'   => $customer->name ?? '',
                        'customer_email'   => $customer->email ?? '',
                        'customer_phone1'   => $customer->phone ?? '',
                        'customer_phone2'   => $customer->phone2 ?? '',
                        'customer_address'   => $customer->address->address ?? '',
                        'allOrders' => [],
                    ],
                ];

                // Iterate through orders and build the response
                foreach ($orders as $order) {
                    $orderData = [
                        'order_id' => $order->id ?? '',
                        'invoice_number' => $order->invoice_number ?? '',
                        'invoice_date' => $order->invoice_date ?? '',
                        'thaila_price' => $order->thaila_price ?? '',
                        'is_round_off' => $order->is_round_off ?? '',
                        'round_off_amount' => $order->round_off_amount ?? '',
                        'sub_total' => $order->sub_total ?? '',
                        'grand_total' => $order->grand_total ?? '',
                        'orderProducts' => [],
                    ];

                    // Iterate through order products and build the response
                    foreach ($order->orderProduct as $orderProduct) {
                        $orderData['orderProducts'][] = [
                            'order_product_id' => $orderProduct->id,
                            'product_id' => $orderProduct->product->id,
                            'product_name' => $orderProduct->product->name,
                            'quantity' => $orderProduct->quantity,
                            'price' => $orderProduct->price,
                            'total_price' => $orderProduct->total_price,
                        ];
                    }

                    $responseData['customerData']['allOrders'][] = ['orderData' => $orderData];
                }

                return response()->json($responseData, 200);
            } else {
                $responseData = [
                    'status'            => true,
                    'message'           => 'No Record for Today!',
                ];
                return response()->json($responseData, 200);
            }


        }catch (\Exception $e) {
            dd($e->getMessage().'->'.$e->getLine());
            //Return Error Response
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.error_message'),
            ];
            return response()->json($responseData, 401);
        }

    }
}
