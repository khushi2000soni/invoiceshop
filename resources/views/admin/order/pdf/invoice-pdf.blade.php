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
.cancel-watermark {
    position: fixed;
    top: 20%;
    left: 25%;
    transform: translate(-50%, -50%);
    color: rgba(255, 0, 0, 0.2);
    transform: rotate(-20deg);
    font-weight: bold;
    font-size: 60px;
}
</style>

</head>
<body style="padding: 100px 0 0;margin: 0;font-family: Arial, Helvetica, sans-serif;" class="">
    @if ($type=='deleted')
    <div class="cancel-watermark">Cancelled</div>
    @endif

    <div class="page-header">
		<header style="padding: 10px 0;">
			{{-- <h2 style="margin: 0;color: #2a2a33;font-size: 30px;font-weight: bold;"><strong>Invoice</strong></h2> --}}
            <div style="max-width: 620px;margin: 0 auto;font-size: 16px;">
				{{-- <p style="margin: 0;text-align: center;">Phone no: {{ $order->customer->phone ?? 0 }}</p>
				<h3 style="margin: 0;padding-bottom: 10px;padding-top: 1px;text-align: center;"><strong>Estimate</strong></h3> --}}
				<div style="height: 60px;">
					<div style="width: 50%;line-height: 22px;padding-top: 10px;padding-bottom: 10px;float: left;">
						<strong>Bill To : </strong> {{ $order->customer->name }}
                        <br>
                        <strong>Address : </strong> {{ $order->customer->address->address }}
                        <br><strong>Phone no:</strong> {{ $order->customer->phone ?? 0 }}
					</div>
					<div style="width: 50%;line-height: 22px;padding-top: 10px;padding-bottom: 10px;float: right;text-align: right;">
						<strong>Invoice no:</strong> #{{ $order->invoice_number }}<br><strong>Date:</strong> {{$order->created_at->format('d-M-Y')}}
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
						<th style="padding: 10px;" align="center">Item Name</th>
						<th style="padding: 10px;" align="center">Quantity</th>
						<th style="padding: 10px;" align="center">Price/Unit</th>
						<th style="padding: 10px;" align="center">Amount</th>
					</tr>
				</thead>
				<tbody>

					@foreach ($order->orderProduct as $index => $product)
				    <tr>
				        <td style="padding: 10px;" align="left">{{ $index + 1 }}</td>
						<td style="padding: 10px;" align="center">{{ $product->product->name }}</td>
						<td style="padding: 10px;" align="center">{{ $product->quantity }}</td>
						<td style="padding: 10px;" align="center">{{ $product->price }}</td>
						<td style="padding: 10px;" align="center">{{ $product->total_price }}</td>
					</tr>

		            @endforeach
				</tbody>
				<tfoot>
					<tr>
						<td style="padding: 10px;" align="right" colspan="4"><strong>Thaila</strong></td>
						<td style="padding: 10px;" align="center"><strong>{{ $order->thaila_price ?? 0  }}</strong></td>
					</tr>
                    <tr>
						<td style="padding: 10px;" align="right" colspan="4"><strong>Round Off</strong></td>
						<td style="padding: 10px;" align="center"><strong>{{ $order->round_off ?? 0  }}</strong></td>
					</tr>
                    <tr>
						<td style="padding: 10px;" align="right" colspan="4"><strong>Grand Total</strong></td>
						<td style="padding: 10px;" align="center"><strong>{{ $order->grand_total ?? 0  }}</strong></td>
					</tr>
				</tfoot>
			</table>

		</main>

</body>
</html>
