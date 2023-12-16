<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<title>View Invoice</title>
<style>
 footer{
    position: fixed;
    bottom:0px;
    left: 20px;
    right: 0px;
    height: 50px;
    margin-bottom: -10px;
}

footer .pagenum:before {
content: counter(page);
}
.page-header {
    position: fixed;
    top: 0px;
    left: 0;
    right: 0px;
    height: 200px;
}

/* @font-face {
    font-family: 'Tiro Devanagari Hindi';
    src: url('{{ asset("fonts/TiroDevaHindi-Italic.woff") }}') format('woff'),
        url('{{ asset("fonts/TiroDevaHindi-Italic.ttf") }}') format('truetype');
    font-weight: normal;
    font-style: italic;
    font-display: swap;
}

@font-face {
    font-family: 'Tiro Devanagari Hindi';
    src: url('{{ asset("fonts/TiroDevaHindi-Regular.woff") }}') format('woff'),
        url('{{ asset("fonts/TiroDevaHindi-Regular.ttf") }}') format('truetype');
    font-weight: normal;
    font-style: normal;
    font-display: swap;
} */


/* @font-face {
    font-family: 'Tiro Devanagari Hindi';
    src: url('{{ asset("fonts/TiroDevaHindi-Italic.woff2") }}') format('woff2'),
        url('{{ asset("fonts/TiroDevaHindi-Italic.woff") }}') format('woff');
    font-weight: normal;
    font-style: italic;
    font-display: swap;
}

@font-face {
    font-family: 'Tiro Devanagari Hindi';
    src: url('{{ asset("fonts/TiroDevaHindi-Regular.woff2") }}') format('woff2'),
        url('{{ asset("fonts/TiroDevaHindi-Regular.woff") }}') format('woff');
    font-weight: normal;
    font-style: normal;
    font-display: swap;
} */

@font-face {
    font-family: 'Poppins';
    src: url('Poppins-Light.woff2') format('woff2'),
        url('Poppins-Light.woff') format('woff');
    font-weight: 300;
    font-style: normal;
    font-display: swap;
}

@font-face {
    font-family: 'Poppins';
    src: url('Poppins-Regular.woff2') format('woff2'),
        url('Poppins-Regular.woff') format('woff');
    font-weight: normal;
    font-style: normal;
    font-display: swap;
}




/* @font-face {
    font-family: 'Tiro Devanagari Hindi';
    src: url('{{ asset("fonts/TiroDevanagariHindi-Regular.ttf") }}') format('truetype');
} */
.HI, .hindi{
    font-family: 'Tiro Devanagari Hindi', serif;
}

.EN{
    font-family: 'timefont', sans-serif;
}

body{
    /* font-family: 'timefont', sans-serif; */
    font-family: 'Tiro Devanagari Hindi', serif;
}
.tabledata {
    font-family: 'timefont', sans-serif;
}
.headerBill {
    line-height: 15px;
}
.headerBill strong, .invoiceHeading{
    font-family: 'timefont', sans-serif;
}

.cancel-watermark {
    position: fixed;
    top: 20%;
    left: 25%;
    transform: translate(-50%, -50%);
    color: rgba(255, 0, 0, 0.2);
    transform: rotate(-20deg);

    font-size: 60px;
}

.pdfFooter .amountHeadning {
    font-size: 15px;
    font-weight: bold;
    margin-bottom: 5px
}
.loremtext {
    font-size: 14px
}
.pdfRHS .valus{
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 4px;
    font-size: 14px;
    line-height: normal;
}
.pdfRHS .valus.totalamount{
    border-top: 1px solid #000;
    border-bottom: 1px solid #000;
    font-size: 16px;
    font-weight: bold;
    margin-top: 5px
}
</style>

</head>
<body style="padding: 100px 0 0;margin: 0;" class="">
    @if ($type=='deleted')
    <div class="cancel-watermark">Cancelled</div>
    @endif

    <div class="page-header">
		<header style="padding: 10px 0;">
			{{-- <h2 class="invoiceHeading" style="margin: 0;color: #2a2a33;font-size: 20px; text-align:center;"><strong>Invoice</strong></h2> --}}
            <div style="max-width: 700px;margin: 0 auto;font-size: 16px;">
				{{-- <p style="margin: 0;text-align: center;">Phone no: {{ $order->customer->phone ?? 0 }}</p>
				<h3 style="margin: 0;padding-bottom: 10px;padding-top: 1px;text-align: center;"><strong>Estimate</strong></h3> --}}
				<div style="height: 60px;">
					<div class="" style="width: 50%;line-height: 22px;padding-top: 1px;padding-bottom: 5px;float: left;">
						<div class="headerBill" style="font-size: 20px;"><strong>Bill To : </strong> {{ $order->customer->name }}</div>
                        {{-- <br> --}}
                        <div class="headerBill" style="font-size: 20px;"><strong>Address : </strong> {{ $order->customer->address->address }}</div>
                        {{-- <br> --}}
                        <div class="headerBill " style="font-size: 20px;"><strong>Phone no:</strong> {{ $order->customer->phone ?? 0 }}</div>
					</div>
					<div style="width: 50%;line-height: 22px;padding-top: 1px;padding-bottom: 5px;float: right;text-align: right;">
                        <div class="headerBill" style="font-size: 20px;"><strong>Invoice no:</strong> #{{ $order->invoice_number }}</div>
                        <div class="headerBill" style="font-size: 20px;"><strong>Date:</strong> {{$order->created_at->format('d-M-Y')}}</div>
                        <div class="headerBill" style="font-size: 20px;"><strong>Time:</strong> {{$order->created_at->format('H:i:s')}}</div>
					</div>
				</div>
			</div>
		</header>
    </div>
        <footer>
            <div class="pagenum-container"><small>Page <span class="pagenum"></span></small></div>
        </footer>
		<main class="main tabledata" style="max-width: 700px;margin: 0px auto 0px;padding: 40px 0px;padding-top: 0;">
			<table cellpadding="0" cellspacing="0" border="1" width="100%" style="color: #000;font-size: 16px;">
				<thead>
					<tr>
						<th style="padding: 5px 10px; font-weight: bold; width: 30px;" align="left">Sn.</th>
						<th style="padding: 5px 10px; font-weight: bold;" align="left">Item Name</th>
						<th style="padding: 5px 10px; font-weight: bold; width: 80px;" align="right">Quantity</th>
						<th style="padding: 5px 10px; font-weight: bold; width: 80px;" align="right">Price</th>
						<th style="padding: 5px 10px; font-weight: bold; width: 150px;" align="right">Amount</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($order->orderProduct as $index => $product)
				    <tr>
				        <td style="padding: 5px 10px;" align="left">{{ $index + 1 }}</td>
						<td style="padding: 5px 10px;" align="left">{{ $product->product->name ?? ''}}</td>
						<td style="padding: 5px 10px;" align="right">{{ handleDataTypeThreeDigit($product->quantity) ?? ''}}</td>
						<td style="padding: 5px 10px;" align="right">{{ handleDataTypeTwoDigit($product->price) ?? ''}}</td>
						<td style="padding: 5px 10px;" align="right">{{ handleDataTypeTwoDigit($product->total_price) ?? '0'}}</td>
					</tr>
		            @endforeach
				</tbody>
			</table>


            <table class="pdfFooter" cellpadding="0" cellspacing="0" style="width: 100%; margin-top: 30px">
                <tr>
                    <td  style="padding-bottom: 10px" class="amountHeadning">{{--Invoice Amount In Words--}}</td>
                    <td  style="padding-bottom: 5px;font-size: 20px;" class="amountHeadning">Amounts</td>
                </tr>
                <tr>
                    <td class="loremtext" style="font-size: 14px; padding: 4px 4px 4px 4px;">{{--{{ convertToWords($order->grand_total ?? 0) }} --}}</td>
                    <td style="width: 100px; padding: 4px; font-size: 14px;"><div class="valus">Sub Total </div></td>
                    <td style="width: 200px;font-size: 14px; padding: 4px;" align="right"><span class="amounnt">{{ handleDataTypeTwoDigit($order->sub_total) ?? 0  }}</span></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width: 100px; padding: 4px; font-size: 14px;"><div class="valus hindi">@lang('quickadmin.thaila') </div></td>
                    <td style="width: 200px;font-size: 14px; padding: 4px;" align="right"><span class="amounnt">{{ handleDataTypeTwoDigit($order->thaila_price) ?? 0  }}</span></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width: 100px; padding: 4px; font-size: 14px;"><div class="valus">Round Off</div></td>
                    <td style="width: 200px;font-size: 14px; padding: 4px;" align="right"><span class="amounnt">{{ handleDataTypeTwoDigit($order->round_off) ?? 0  }}</span></td>
                </tr>
                <tr >
                    <td></td>
                    <td style="width: 200px; padding: 4px; font-size: 20px;  border-top: 1px solid #000; border-bottom: 1px solid #000;"><div class="valus totalamount"><strong>Grand Total</strong></div></td>
                    <td style="width: 200px;font-size: 20px; padding: 4px; border-top: 1px solid #000; border-bottom: 1px solid #000;" align="right"><strong class="amounnt">{{ handleDataTypeTwoDigit($order->grand_total) ?? 0  }}</strong></td>
                </tr>
                <tr>
                    <td colspan="3" class="loremtext" style="font-size: 14px; padding: 50px 20px 4px 4px;"><i><span style="color: red;">Remark: </span> {{ getSetting('custom_invoice_print_message') ?? ''}}</i></td>
                </tr>
            </table>



		</main>

</body>
</html>
