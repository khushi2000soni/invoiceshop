<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@lang('quickadmin.address.fields.list-title')</title>
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
/* .page-header {
    position: fixed;
    top: 0px;
    left: 0;
    right: 0px;
    height: 200px;
} */

</style>

</head>
<body style="padding: 50px 0 0;margin: 0;font-family: Arial, Helvetica, sans-serif;" class="">

    <div class="page-header">
		<header style="padding: 1px 0;">
			<h2 style="margin: 0;color: #2a2a33;font-size: 30px;font-weight: bold; text-align:center;"><strong>@lang('quickadmin.address.fields.list-title')</strong></h2>
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
						<th style="padding: 10px;" align="center">@lang('quickadmin.address.fields.list.address')</th>
						<th style="padding: 10px;" align="center">@lang('quickadmin.address.fields.list.no_of_customer')</th>
						<th style="padding: 10px;" align="center">@lang('quickadmin.address.fields.list.created_at')</th>

					</tr>
				</thead>
				<tbody>

					@forelse ($addresses as $key => $address)
				    <tr>
				        <td style="padding: 10px;" align="left">{{ $key + 1 }}</td>
						<td style="padding: 10px;" align="center">{{ $address->address }}</td>
						<td style="padding: 10px;" align="center">{{ $address->customers->count() ?? 0 }}</td>
						<td style="padding: 10px;" align="center">{{ $address->created_at->format('d-M-Y') }}</td>
					</tr>
                    @empty
                    <tr>
                        <td colspan="4">No Record Found!</td>
                    </tr>
                    @endforelse
				</tbody>

			</table>

		</main>

</body>
</html>
