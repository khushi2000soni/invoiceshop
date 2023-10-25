<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View Invoice</title>
<style>
 footer{
        position: fixed;
        bottom:0px;
        left: 30px;
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
</style>

</head>
<body style="padding: 160px 0 0;margin: 0;font-family: Arial, Helvetica, sans-serif;">
    <div class="page-header">
		<header style="padding: 10px 0;">
			{{-- <h2 style="margin: 0;color: #2a2a33;font-size: 30px;font-weight: bold;"><strong>Invoice</strong></h2> --}}
            <div style="max-width: 620px;margin: 0 auto;font-size: 16px;">
				<p style="margin: 0;text-align: center;">Phone no: {{ $order->customer->phone ?? 0 }}</p>
				<h3 style="margin: 0;padding-bottom: 10px;padding-top: 1px;text-align: center;"><strong>Estimate</strong></h3>
				<div style="height: 60px;">
					<div style="width: 50%;line-height: 22px;padding-top: 10px;padding-bottom: 10px;float: left;">
						<strong>Bill To</strong><br>{{ $order->customer->name }}
					</div>
					<div style="width: 50%;line-height: 22px;padding-top: 10px;padding-bottom: 10px;float: right;text-align: right;">
						Invoice no: #{{ $order->invoice_number }}<br><strong>Date:- {{$order->created_at->format('d-M-Y')}}</strong><br><strong>Time: {{$order->created_at->format('H:i A')}}</strong>
					</div>
				</div>
			</div>
		</header>
    </div>
        <footer>
            <div class="pagenum-container"><small>Page <span class="pagenum"></span></small></div>
        </footer>
		<main class="main" style="max-width: 620px;margin: 0 auto;padding: 40px;padding-top: 0;">

			<table cellpadding="0" cellspacing="0" border="1" width="100%" style="color: #000;font-size: 16px;">
				<thead>
					<tr>
						<th style="padding: 10px;" align="left">SR NO.</th>
						<th style="padding: 10px;" align="left">Item Name</th>
						<th style="padding: 10px;" align="right">Quantity</th>
						<th style="padding: 10px;" align="right">Price/Unit</th>
						<th style="padding: 10px;" align="right">Amount</th>
					</tr>
				</thead>
				<tbody>
                    @php
                    $totalQuantity = 0;
                    $totalPrice = 0;
                    @endphp
					@foreach ($order->orderProduct()->get() as $index => $product)
				    <tr>
				        <td style="padding: 10px;" align="left">{{ $index + 1 }}</td>
						<td style="padding: 10px;" align="left">{{ $product->product->name }}</td>
						<td style="padding: 10px;" align="right">{{ $product->quantity }}</td>
						<td style="padding: 10px;" align="right">{{ $product->price }}</td>
						<td style="padding: 10px;" align="right">{{ $product->total_price }}</td>
					</tr>
					@php
		            $totalQuantity += $product->quantity;
		            $totalPrice += $product->total_price;
		        	@endphp
		            @endforeach
				</tbody>
				<tfoot>
					<tr>
						<td style="padding: 10px;" align="left"></td>
						<td style="padding: 10px;" align="left"><strong>Total</strong></td>
						<td style="padding: 10px;" align="right"><strong>{{ $totalQuantity }}</strong></td>
						<td style="padding: 10px;" align="right"></td>
						<td style="padding: 10px;" align="right"><strong>{{ $totalPrice }}</strong></td>
					</tr>
				</tfoot>
			</table>
			<table cellpadding="0" cellspacing="0" width="100%" style="color: #000;font-size: 16px;">
				<tr>
					<td align="right" style="padding: 10px;color: #2a2a33;"><strong>Thaila</strong></td>
					<td width="50" align="center" style="padding: 10px;color: #2a2a33;"><strong>:</strong></td>
					<td align="right" width="80" style="padding:  10px 0 10px 10px;color: #2a2a33;"><strong>{{ $order->thaila_price ?? 0 }}</td>
				</tr>
				<tr>
					<td align="right" style="padding: 10px;color: #2a2a33;"><strong>Round Off</strong></td>
					<td width="50" align="center" style="padding: 10px;color: #2a2a33;"><strong>:</strong></td>
					<td align="right" width="80" style="padding:  10px 0 10px 10px;color: #2a2a33;"><strong>{{ $order->round_off ?? 0 }}</strong></td>
				</tr>
				<tr>
					<td align="right" style="padding: 10px;color: #2a2a33;"><strong>Grand Total</strong></td>
					<td width="50" align="center" style="padding: 10px;color: #2a2a33;"><strong>:</strong></td>
					<td align="right" width="80" style="padding: 10px 0 10px 10px;color: #2a2a33;"><strong>{{ $order->grand_total ?? 0 }}</strong></td>
				</tr>
			</table>
		</main>

</body>
</html>
