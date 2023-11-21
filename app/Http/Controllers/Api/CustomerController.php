<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
            $orders = Order::with('customer')->whereDate('created_at', $today)->get();
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
                        'customer_id_name'   => $order->customer ? $order->customer->name : '',
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
}
