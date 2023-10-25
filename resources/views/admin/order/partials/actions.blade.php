@can('invoice_print')
<a type="button" class="btn btn-icon btn-info print-order-btn p-1 px-2" href="{{route('orders.print-pdf', $order->id)}}" title="@lang('quickadmin.qa_print')"><i class="fas fa-print"></i> </a>
@endcan

@can('invoice_share')
<a role="button" class="btn btn-icon btn-success share-order-btn p-1 px-2 mx-1" data-toggle="modal" data-target="#centerModal" title="@lang('quickadmin.qa_share')"><i class="fas fa-share"></i> </a>
<div class="modal fade px-3" id="centerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">@lang('quickadmin.order.share_invoice')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('orders.share-email', $order->id) }}" class="btn btn-primary btn-block m-2">
                                <i class="fas fa-envelope font-30 py-1 px-1"></i>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('orders.share-whatsapp', $order->id) }}" class="btn btn-success btn-block m-2">
                                <i class="fab fa-whatsapp font-30 py-1 px-1"></i>
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
    <button class="btn btn-primary dropdown-toggle px-2" type="button"
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
        @can('invoice_delete')
        <form action="{{route('orders.destroy', $order->id)}}" method="POST" class="deleteForm m-1" id="deleteForm">
            <a class="dropdown-item has-icon record_delete_btn" role="button" href="#"><i class="fas fa-trash"></i> @lang('quickadmin.qa_delete')</a>
        </form>
        @endcan
    </div>
</div>
@endcan

