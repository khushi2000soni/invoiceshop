{{-- @can('customer_edit')
<button type="button" class="btn btn-icon btn-info edit-invoice-customer-btn p-1 mx-1"  data-href="{{route('customers.editPhone', $order->customer->id)}}" title="Edit Phone Number"><i class="fas fa-edit"></i></button>
@endcan --}}

@can('invoice_print')
<button class="btn btn-icon btn-info print-order-btn p-1 px-2 print-button" data-href="{{route('orders.print', $order->id)}}" title="@lang('quickadmin.qa_print')" ><i class="fas fa-print"></i> </button>
{{-- <a type="button" class="btn btn-icon btn-info print-order-btn p-1 px-2" href="{{route('orders.print-pdf', $order->id)}}" title="@lang('quickadmin.qa_print')"><i class="fas fa-print"></i> </a> --}}
@endcan

@can('invoice_share')
<a role="button" class="btn btn-icon share-order-btn p-1 px-2 mx-1" data-toggle="modal" data-target="#ShareInvoiceModal" title="@lang('quickadmin.qa_share')"><i class="fas fa-share"></i> </a>
<div class="modal fade px-3" id="ShareInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="ShareInvoiceModaltitlte" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ShareInvoiceModaltitlte">@lang('quickadmin.order.share_invoice')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            @php
                                $recipientMail = $order->customer->email ?? "";
                            @endphp
                            <a href="javascript:void(0);" data-order-id="{{ $order->id }}" data-recipient-email="{{ $recipientMail }}" data-href="{{route('orders.generate-pdf', $order->id)}}" class="btn btn-danger dangerBtn text-white btn-block m-2 share-email-btn">
                                <i class="fas fa-envelope py-1 px-1"></i>
                            </a>
                        </div>
                        <div class="col-6">
                            @php
                                $recipientNumber = $order->customer->phone ?? ""; // Replace with the actual recipient's phone number
                            @endphp
                            <a href="javascript:void(0);" class="btn btn-success btn-block m-2 share-whatsapp-btn" data-order-id="{{ $order->id }}" data-recipient-number="{{ $recipientNumber }}" data-href="{{route('orders.generate-pdf', $order->id)}}">
                                <i class="fab fa-whatsapp py-1 px-1"></i>
                            </a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endcan


@can('invoice_access')
<div class="dropdown d-inline">
    <button class="btn dropdown-toggle px-2" type="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="@lang('quickadmin.qa_view')">
        <i class="fas fa-align-justify"></i>
    </button>
    <div class="dropdown-menu">
        {{-- @can('invoice_show')
        <a class="dropdown-item has-icon" href="{{route('orders.edit', $order->id)}}" title="@lang('quickadmin.qa_view')"><i class="far fa-eye"></i> @lang('quickadmin.qa_view')</a>
        @endcan --}}
        @can('invoice_download')
        <a class="dropdown-item has-icon" href="{{route('orders.generate-pdf', $order->id)}}" title="@lang('quickadmin.qa_download')"><i class="fas fa-cloud-download-alt"></i>@lang('quickadmin.qa_download')</a>
        @endcan
        @can('invoice_edit')
        <a class="dropdown-item has-icon" href="{{route('orders.edit', $order->id)}}" title="@lang('quickadmin.qa_edit')"><i class="fas fa-edit"></i> @lang('quickadmin.qa_edit')</a>
        @endcan
        @can('invoice_show')
        <a class="dropdown-item has-icon" href="{{route('orders.print-pdf', $order->id)}}" title="@lang('quickadmin.qa_view')" target="_blank"><i class="fas fa-eye"></i> @lang('quickadmin.qa_view')</a>
        @endcan
        @can('invoice_delete')
        <form action="{{route('orders.destroy', $order->id)}}" method="POST" class="deleteForm m-1" id="deleteForm">
            <button class="dropdown-item has-icon record_delete_btn deleteBtn  d-inline-flex align-items-center" type="submit" href="#"><i class="fas fa-trash"></i> @lang('quickadmin.qa_delete')</button>
        </form>
        @endcan
    </div>
</div>
@endcan

