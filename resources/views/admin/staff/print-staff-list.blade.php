@extends('layouts.print-view.print-layout')
@section('title')@lang('quickadmin.user-management.fields.list-title')@endsection

@section('custom_css')

@endsection

@section('content')
    <div class="page-header">
        <header style="padding: 1px 0;">
            <h2 style="margin: 0;color: #2a2a33;font-size: 20px;font-weight: bold; text-align:center;"><strong>@lang('quickadmin.user-management.fields.list-title')</strong></h2>
        </header>
    </div>
    {{-- <footer>
        <div class="pagenum-container"><small>Page <span class="pagenum"></span></small></div>
    </footer> --}}
    <main class="main" style="max-width: 840px;margin: 0 auto;padding: 30px;padding-top: 0;">
        <table cellpadding="0" cellspacing="0"  width="100%" style="color: #000;font-size: 16px;padding-right: 20px;">
            <thead>
                <tr>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="center">@lang('quickadmin.users.fields.name')</th>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="center">@lang('quickadmin.users.fields.role')</th>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="center">@lang('quickadmin.users.fields.usernameid')</th>
                    <th style="padding: 10px;border: 1px solid #000;border-right: none;" align="center">@lang('quickadmin.users.fields.email')</th>
                    <th style="padding: 10px;border: 1px solid #000;" align="center">@lang('quickadmin.users.fields.phone')</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($allstaff as $key => $staff)
                    @php
                        $role = $staff->roles->first();
                    @endphp
                <tr>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="center">{{ $staff->name ?? '' }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="center">{{ $role ? $role->name : '' }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="center">{{ $staff->username ?? '' }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-right: none;border-top: none;" align="center">{{ $staff->email ?? '' }}</td>
                    <td style="padding: 10px;border: 1px solid #000;border-top: none;" align="center">{{ $staff->phone ?? '' }}</td>
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
