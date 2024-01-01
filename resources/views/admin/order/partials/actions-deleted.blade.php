@can('invoice_print')
<button class="btn btn-icon btn-info print-order-btn p-1 px-2 print-button" data-href="{{route('orders.print', ['order'=> $order->id,'type'=>'deleted'])}}" title="@lang('quickadmin.qa_print')" ><x-svg-icon icon="print" /> </button>
@endcan

@can('invoice_show')
{{-- <button type="button" class="btn btn-outline-dark view-delete-orders px-2" data-toggle="modal" data-target="#OrderModal" data-href="{{route('orders.show', $order->id)}}">@lang('quickadmin.qa_view')</button> --}}

<a type="button" class="btn btn-icon btn-info view-delete-orders p-1 px-2" href="{{route('orders.print-pdf',['order'=>$order->id,'type'=>'deleted'] )}}" title="@lang('quickadmin.qa_view')" target="_blank"><x-svg-icon icon="view" /> </a>
@endcan

@can('invoice_restore')
<form action="{{route('orders.restore', $order->id)}}" method="POST" class="restoreForm m-1" id="restoreForm">
    <button class="btn btn-icon btn-info restoreBtn  d-inline-flex align-items-center" type="submit" title="@lang('quickadmin.qa_restore')"><x-svg-icon icon="restore" /></button>
</form>
@endcan
