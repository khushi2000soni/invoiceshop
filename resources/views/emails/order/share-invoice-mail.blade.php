@extends('emails.layouts.mail')
@section('styles')
  <style>

  </style>
@endsection

@section('email-content')
    <tr>
        <td>
            {{-- <p class="mail-title" style="font-size:14px;">
                <b>Hello</b> {{ $name ?? "" }},
            </p> --}}
            <div class="mail-desc">
                <p style="font-size:14px;">{{ getSetting('share_invoice_mail_message') }}</p>
            </div>
        </td>
    </tr>
@endsection
