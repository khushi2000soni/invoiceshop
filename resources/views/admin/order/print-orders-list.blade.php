@extends('layouts.print-view.print-layout')
@section('title')@lang('quickadmin.order-management.fields.list')@endsection

@section('custom_css')

@endsection

@section('content')
    <div class="page-header">
        <header style="padding: 1px 0;">
            <h2 style="margin: 0;color: #2a2a33;font-size: 20px;font-weight: bold; text-align:center;"><strong>@lang('quickadmin.order-management.fields.list')</strong></h2>
        </header>
    </div>
    <main class="main" style="max-width: 700px;margin: 0 auto;padding: 40px;padding-top: 0;">
        <table cellpadding="0" cellspacing="0" width="100%" style="color: #000;font-size: 16px;padding-right: 20px;">
            <thead>
                <tr>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="center">@lang('quickadmin.order.fields.invoice_number')</th>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="center">@lang('quickadmin.order.fields.customer_name')</th>
                    <th style="padding: 10px;border: 1px solid #000;" align="center">@lang('quickadmin.order.fields.total_price')</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($allorders as $key => $order)
                <tr>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="center">{{  $order->invoice_number ?? '' }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="center">{{ $order->customer ? $order->customer->name : ''}}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-top: none;" align="center">{{ $order->grand_total ?? '0'}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">No Record Found!</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="right">@lang('quickadmin.order.fields.grand_total')</th>
                    <th style="padding: 10px;border: 1px solid #000;border-top: none;" align="center">{{ $sumGrandTotal }}</th>
                </tr>
            </tfoot>
        </table>
    </main>
@endsection
