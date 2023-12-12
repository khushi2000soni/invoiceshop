<?php

namespace App\Http\Controllers\Api;

use DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CreateRequest;
use App\Models\Address;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function todayInvoiceGroupList(){
        //abort_if(Gate::denies('customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try{
            $today = Carbon::today();
            $customerOrders = Customer::select('customers.id as customer_id','customers.name as customer_name',
                DB::raw('COUNT(orders.id) as total_orders'),
                DB::raw('SUM(orders.grand_total) as total_order_amount'),
                'orders.invoice_date as invoice_date'
            )
            ->leftJoin('orders', 'customers.id', '=', 'orders.customer_id')
            ->where('orders.invoice_date', $today)
            ->whereNull('orders.deleted_at')
            ->orderByDesc('orders.created_at')
            ->groupBy('customers.id', 'customers.name')
            ->get()->toArray();

            return response()->json([
                'status' => true,
                'data' => $customerOrders
            ])->setStatusCode(Response::HTTP_OK);

            // return response()->json($customerOrders, 200);

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

    public function PartyAllInvoiceList(){

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

            if($orders->isNotEmpty()){
                $responseData = [
                    'status'    => true,
                    'message'   => trans('messages.success'),
                    'userData'  => [],
                ];

                $groupedOrders = $orders->groupBy('customer_id');

                foreach ($groupedOrders as $customerId => $customerOrders) {

                    $customer = $customerOrders->first()->customer;
                    //dd($customerOrders);
                    $customerData = [
                        'customer_id' => $customer->id ?? '',
                        'no_of_invoice' => $customerOrders->count(),
                        'invoices_total' => number_format($customerOrders->sum('grand_total'), 2),
                        'customer_name' => $customer->name ?? '',
                        'customer_email' => $customer->email ?? '',
                        'customer_phone1' => $customer->phone ?? '',
                        'customer_phone2' => $customer->phone2 ?? '',
                        'customer_address' => $customer->address? $customer->address->address : '',
                        'invoiceData' => $customerOrders->map(function ($order) {
                            return [
                                'order_id' => $order->id,
                                'invoice_number' => $order->invoice_number,
                                'grand_total' => number_format($order->grand_total, 2),
                                'invoice_date' => $order->created_at->toDateString(),
                            ];
                        }),
                    ];

                    $responseData['userData'][] = $customerData;
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
                    'message'   => trans('messages.success'),
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
                    'message' => trans('messages.success'),
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

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => ['required','string','max:150', 'regex:/^[^\s]+(?:\s[^\s]+)?$/'],
            'guardian_name' => ['required','string','max:150','regex:/^[^\s]+$/'],
            // 'email' => ['required','email','unique:customers,email'],
            'phone' => ['required','digits:10','numeric','unique:customers,phone'],
            'phone2' => ['nullable','digits:10','numeric','unique:customers,phone2'],
            'city_id'=>['required','numeric'],
        ]);

        if($validator->fails()){
            $responseData = [
                'status'        => false,
                'validation_errors' => $validator->errors(),
            ];
            return response()->json($responseData, 401);
        }

        try{
            $input = $request->all();
            $input['name']=ucwords($request->name);
            $input['address_id']=ucwords($request->city_id);
            $input['guardian_name']=ucwords($request->guardian_name);
            $customer=Customer::create($input);
            $responseData = [
                'status'            => true,
                'message'           => trans('messages.success'),
                'userData'          => [
                    'customer_id'        => $customer->id ?? '',
                    'customer_name'   => $customer->name ?? '',
                    'customer_email'   => $customer->email ?? '',
                    'customer_phone1'   => $customer->phone ?? '',
                    'customer_phone2'   => $customer->phone2 ?? '',
                    'customer_address'   => $customer->address->address ?? '',
                ],
            ];
            return response()->json($responseData, 200);
        }catch (\Exception $e) {
            //dd($e->getMessage().'->'.$e->getLine());
            //Return Error Response
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.error_message'),
            ];
            return response()->json($responseData, 401);
        }
    }

    public function AllCustomerList(){
        $allcustomers = Customer::orderBy('id','desc')->get();

        $responseData = [
            'status'    => true,
            'message'   => trans('messages.success'),
            'customerData'  => [],
        ];
        foreach ($allcustomers as $customer) {
            $responseData['customerData'][] = [
                'customer_id'           => $customer->id ?? '',
                'customer_name'     => $customer->name ?? '',
            ];
        }

        return response()->json($responseData, 200);
    }


}
