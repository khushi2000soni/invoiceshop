<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <style>

            p, td {
                 font-family: freeserif;
                 /* font-family: 'Mangal', sans-serif; */
            }

            /* @page {
            margin-top: 5cm;
            margin-header: 0.5cm;
            margin-footer: 2cm;
            header: page-header;
            footer: page-footer;
            }
            @page :first {
                header: page-header;
            } */

            .header {
            text-align: center;
            /* border-bottom: 1px solid #000; */
        }
        footer{
            position: fixed;
            bottom:-50px;
            left: 0;
            right: 0px;
            height: 50px;
            margin-bottom: 0px;
        }

        .tablebody * {
            box-sizing: border-box;
        }

        /* @page {
            size: A5;
            margin:0 auto;
        } */

        </style>
    </head>
<body  class="@if($type=='deleted') table_wrapper @endif tablebody" >
    <header name="page-header" class="header">
        <table  style="max-width: 100%; width: 100%; margin: 0px auto; padding-bottom: 10px;">
            <tbody>
                @if (!is_null(getSetting('invoice_pdf_top_title')))
                <tr>
                    <th colspan="2" style="text-align: center; font-size: 22px; padding-bottom: 20px; font-weight: 400;">{{ getSetting('invoice_pdf_top_title') ?? ''}}</th>
                </tr>
                @endif
                <tr>
                    <td style="font-size: 22px;"><strong>Bill To: {{ str_limit_custom($order->customer->name, 25) }}
                    </strong></td>
                    <td style="font-size: 22px; text-align: right;"><strong>Invoice no : #{{ $order->invoice_number }}</strong>  </td>
                </tr>
                <tr>
                    <td style="font-size: 22px;"><strong>Address : {{ $order->customer->address->address }}</strong> </td>
                    <td style="font-size: 22px; text-align: right;"><strong>Date : {{$order->created_at->format('d-m-Y')}}</strong> </td>
                </tr>
                <tr>
                    <td style="font-size: 22px;"><strong>Phone no: {{ $order->customer->phone ?? 'N/A' }}</strong>  </td>
                    <td style="font-size: 22px; text-align: right;"><strong>Time : {{$order->created_at->format('h:i A')}}</strong>  </td>
                </tr>
            </tbody>
        </table>
    </header>

    <table style="max-width: 100%; width: 98.8%; margin: 0px auto; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="padding: 5px 10px; border: 1px solid #000; text-align: start; font-size: 20px; width: 10%"><strong>Sn.</strong></th>
                <th style="padding: 5px 10px; border: 1px solid #000; text-align: start; font-size: 20px; width: 40%"><strong>Item Name</strong> </th>
                <th style="padding: 5px 10px; border: 1px solid #000; text-align: right; font-size: 20px; width: 15%"><strong>Quantity</strong></th>
                <th style="padding: 5px 10px; border: 1px solid #000; text-align: right; font-size: 20px; width: 15%"><strong>Price</strong></th>
                <th style="padding: 5px 10px; border: 1px solid #000; text-align: right; font-size: 20px; width: 20%"><strong>Amount</strong></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderProduct as $index => $product)

            <tr>
                <td style="padding: 5px 10px; border: 1px solid #000; text-align: start; font-size: 20px;">{{ $index + 1 }}</td>
                <td style="padding: 5px 10px; border: 1px solid #000; text-align: start; font-size: 20px;">{{ $product->product->name ?? ''}}</td>
                <td style="padding: 5px 10px; border: 1px solid #000; text-align: right; font-size: 20px;">{{ handleDataTypeThreeDigit($product->quantity) ?? ''}}</td>
                <td style="padding: 5px 10px; border: 1px solid #000; text-align: right; font-size: 20px;">{{ handleDataTypeTwoDigit($product->price) ?? ''}}</td>
                <td style="padding: 5px 10px; border: 1px solid #000; text-align: right; font-size: 20px;">{{ handleDataTypeTwoDigit($product->total_price) ?? '0'}}</td>
            </tr>

            {{-- @if (($index + 1) % 16 === 0)
                <pagebreak />
                @endif --}}
                @endforeach
        </tbody>
    </table>
    <table style="max-width: 100%; width: 60%; border-collapse: collapse; margin-left: auto;margin-top:20px">
        <tbody>
            <tr>
                <td style="padding: 5px 10px; text-align: start; font-size: 20px;">Sub Total </td>
                <td style="padding: 5px 10px; text-align: right; font-size: 20px;">{{ handleDataTypeTwoDigit($order->sub_total) ?? 0  }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 10px; text-align: start; font-size: 20px;">@lang('quickadmin.thaila')</td>
                <td style="padding: 5px 10px; text-align: right; font-size: 20px;">{{ handleDataTypeTwoDigit($order->thaila_price) ?? 0  }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 10px; text-align: start; font-size: 20px;">Round Off </td>
                <td style="padding: 5px 10px; text-align: right; font-size: 20px;">{{ handleDataTypeTwoDigit($order->round_off) ?? 0  }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 10px; text-align: start; font-size: 25px; border-bottom: 1px solid #000; border-top: 1px solid #000;"><strong>Grand Total</strong></td>
                <td style="padding: 5px 10px; text-align: right; font-size: 25px; border-bottom: 1px solid #000; border-top: 1px solid #000;"><strong>{{ handleDataTypeTwoDigit($order->grand_total) ?? 0  }} </strong></td>
            </tr>
        </tbody>
    </table>

    <table style="max-width: 100%; width: 100%; margin: 0px auto; border-collapse: collapse;">
        <tbody>
            <tr>
                <td colspan="2" style="padding: 50px 5px 0px; text-align: start; font-size: 20px;"><strong><span style="color: red;">Remark :</span> {{ getSetting('custom_invoice_print_message') ?? ''}} </strong></td>
            </tr>
        </tbody>
    </table>
    <footer name="page-footer">

    </footer>
</body>
</html>

