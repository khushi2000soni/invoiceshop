@extends('layouts.print-view.print-layout')
@section('title')@lang('quickadmin.order-management.fields.list')@endsection

@section('custom_css')
<!-- <style>
    @media print {
    @page {
        size: A5;
        margin:0 auto;
    }

    html, body {
        margin: 0;
        padding: 0;
    }

    body{
        display: flex;
        align-items: center;
        justify-content: start;
        flex-direction:column;
    }
    
    html
    {
        zoom:75%;
    }

    table{
        width: 100%;
    }
}
</style> -->
@endsection

@section('content')
    <div class="page-header">
        <header style="padding: 1px 0; max-width: 100%; margin: 0 auto;">
            <h2 style="margin: 0;color: #2a2a33;font-size: 20px;font-weight: bold; text-align:center;"><strong>@lang('quickadmin.order-management.fields.list')</strong></h2>

        </header>
    </div>
    <main class="main" style="max-width: 100%;margin: 0 auto;padding: 40px 0;padding-top: 20px;">
        <table cellpadding="0" cellspacing="0" width="100%" style="color: #000;font-size: 16px;">
            <thead>
                <tr>
                    <td colspan="4"><div class=""style="color: #2a2a33;font-size: 20px; text-align:left;">@lang('quickadmin.order.fields.duration') : {{ $duration}}</div></td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-bottom: 20px"><div class="" style="color: #2a2a33;font-size: 20px; text-align:left;">@lang('quickadmin.order.fields.customer') : {{ $customer_name }}</div></td>
                </tr>
            </thead>
            <thead>
                <tr>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="center">@lang('quickadmin.order.fields.invoice_number')</th>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="center">@lang('quickadmin.order.fields.customer_name')</th>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="center">@lang('quickadmin.order.fields.invoice_date')</th>
                    <th style="padding: 10px;border: 1px solid #000;" align="center">@lang('quickadmin.order.fields.total_price')</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($allorders as $key => $order)
                <tr>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="center">{{  $order->invoice_number ?? '' }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="center">{{ $order->customer ? $order->customer->full_name : ''}}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-top: none;border-right: none;" align="center">{{ $order->created_at->format('d-m-Y') }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-top: none;" align="center">{{ $order->grand_total ?? '0'}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 10px;border: 1px solid #000;border-top: none;" align="center">No Record Found!</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="right">@lang('quickadmin.order.fields.grand_total')</th>
                    <th style="padding: 10px;border: 1px solid #000;border-top: none;" align="center">{{ $sumGrandTotal }}</th>
                </tr>
            </tfoot>
        </table>
    </main>
@endsection
