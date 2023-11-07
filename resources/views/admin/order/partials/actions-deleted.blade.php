
@can('invoice_show')
{{-- <button type="button" class="btn btn-outline-dark view-delete-orders px-2" data-toggle="modal" data-target="#OrderModal" data-href="{{route('orders.show', $order->id)}}">@lang('quickadmin.qa_view')</button> --}}

<a type="button" class="btn btn-icon btn-info view-delete-orders p-1 px-2" href="{{route('orders.print-pdf',['order'=>$order->id,'type'=>'deleted'] )}}" title="@lang('quickadmin.qa_view')" target="_blank"><i class="fas fa-eye"></i> </a>
@endcan

