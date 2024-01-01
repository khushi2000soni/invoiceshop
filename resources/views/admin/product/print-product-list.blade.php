@extends('layouts.print-view.print-layout')
@section('title')@lang('quickadmin.product-management.fields.list')@endsection

@section('custom_css')

@endsection

@section('content')
    <div class="page-header">
        <header style="padding: 1px 0;">
            <h2 style="margin: 0;color: #2a2a33;font-size: 20px;font-weight: bold; text-align:center;"><strong>@lang('quickadmin.product-management.fields.list')</strong></h2>
        </header>
    </div>
    {{-- <footer>
        <div class="pagenum-container"><small>Page <span class="pagenum"></span></small></div>
    </footer> --}}
    <main class="main" style="max-width: 620px;margin: 0 auto;padding: 40px;padding-top: 0;">
        <table cellpadding="0" cellspacing="0" width="100%" style="color: #000;font-size: 16px;padding-right: 20px;">
            <thead>
                <tr>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="left">@lang('quickadmin.qa_sn')</th>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="center">@lang('quickadmin.product.fields.name')</th>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="center">@lang('quickadmin.product.fields.category_name')</th>
                    <th style="padding: 10px;border: 1px solid #000;" align="center">@lang('quickadmin.product.fields.order_count')</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($products as $key => $product)
                <tr>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="left">{{ $key + 1 }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="center">{{ ucwords($product->name) ?? '' }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="center">{{ ucwords($product->category->name) ?? '' }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-top: none;" align="center">{{ $product->order_count }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">No Record Found!</td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </main>

@endsection
