@extends('layouts.print-view.print-layout')
@section('title')@lang('quickadmin.product-management.fields.list')@endsection

@section('custom_css')

@endsection

@section('content')
    <div class="page-header">
        <header style="padding: 1px 0;">
            <h2 style="margin: 0;color: #2a2a33;font-size: 30px;font-weight: bold; text-align:center;"><strong>@lang('quickadmin.product-management.fields.list')</strong></h2>
        </header>
    </div>
    {{-- <footer>
        <div class="pagenum-container"><small>Page <span class="pagenum"></span></small></div>
    </footer> --}}
    <main class="main" style="max-width: 620px;margin: 0 auto;padding: 40px;padding-top: 0;">
        <table cellpadding="0" cellspacing="0" border="1" width="100%" style="color: #000;font-size: 16px;">
            <thead>
                <tr>
                    <th style="padding: 10px;" align="left">@lang('quickadmin.qa_sn')</th>
                    <th style="padding: 10px;" align="center">@lang('quickadmin.product.fields.name')</th>
                    <th style="padding: 10px;" align="center">@lang('quickadmin.product.fields.category_name')</th>
                    <th style="padding: 10px;" align="center">@lang('quickadmin.product.fields.created_at')</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($products as $key => $product)
                <tr>
                    <td style="padding: 10px;" align="left">{{ $key + 1 }}</td>
                    <td style="padding: 10px;" align="center">{{ ucwords($product->name) ?? '' }}</td>
                    <td style="padding: 10px;" align="center">{{ ucwords($product->category->name) ?? '' }}</td>
                    <td style="padding: 10px;" align="center">{{ $product->created_at->format('d-M-Y') }}</td>
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
