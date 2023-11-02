@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.order.create_new_order') @endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
<style>
    .buttonGroup{
        gap: 8px
    }
    .invoice hr {
    border-top-color: #ededed;
}
        .custom-select2 select{
			width: 200px;
            z-index: 1;
            position: relative;
		}
		.custom-select2 .form-control-inner{
			position: relative;
		}
		.custom-select2 .form-control-inner label{
			position: absolute;
			left: 10px;
			top: -8px;
			background-color: #fff;
			padding: 0 5px;
			z-index: 1;
			font-size: 12px;
		}
		.select2-results{
			padding-top: 48px;
			position: relative;
		}
		.select2-link2{
			position: absolute;
			top: 6px;
			left: 5px;
			width: 100%;
		}
		.select2-container--default .select2-selection--single,
		.select2-container--default .select2-selection--single .select2-selection__arrow{
			height: 40px;
		}
		.select2-container--default .select2-selection--single .select2-selection__rendered{
			line-height: 41px;
		}
		.select2-search--dropdown .select2-search__field{
			padding: 10px;
			font-size: 15px;
		}
		.select2-search--dropdown .select2-search__field:focus{
			outline: none;
		}
		.select2-link2 .btns {
			color: #3584a5;
			background-color: transparent;
			border: none;
			font-size: 14px;
			padding: 7px 15px;
			cursor: pointer;
			border: 1px solid #3584a5;
			border-radius: 60px;
		}
        #centerModal{
            z-index: 99999;
        }
        #centerModal::before{
            display: none;
        }
        .modal-open .modal-backdrop.show{
            display: block !important;
            z-index: 9999;
        }
</style>

@endsection

@section('main-content')

<section class="section">
    <div class="section-header ">
      <h1>@lang('quickadmin.order.create_new_order') </h1>
      <div class="section-header-breadcrumb ">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">@lang('quickadmin.qa_dashboard')</a></div>
        <div class="breadcrumb-item"><a href="{{ route('orders.index') }}">@lang('quickadmin.order.list')</a></div>
        <div class="breadcrumb-item">@lang('quickadmin.order.new_order')</div>
      </div>
    </div>
    <div class="section-body">
        <form method="post" id="SaveInvoiceForm" action="{{route('orders.store')}}">
            <div class="invoice">
                <div class="invoice-print">
                <div class="row">
                    @can('order_product_create')
                    <div class="col-md-12">
                        @include('admin.order.form')
                    </div>
                    @endcan
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table tablestriped tablehover ordertable">
                        <thead>
                            <tr>
                                <th data-width="40">@lang('quickadmin.qa_action')</th>
                                <th class="text-center d-none">@lang('quickadmin.order.fields.product_id')</th>
                                <th class="text-center">@lang('quickadmin.order.fields.product_name')</th>
                                <th class="text-center">@lang('quickadmin.order.fields.quantity')</th>
                                <th class="text-center">@lang('quickadmin.order.fields.price')</th>
                                <th class="text-center">@lang('quickadmin.order.fields.sub_total')</th>
                                <th class="text-center">
                                    <div class="form-group m-0">
                                    <div class="input-group">
                                        <button type="button" class="btn btn-success" id="addProductBtn"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-right">
                                    <div class="d-flex align-items-center buttonGroup justify-content-end">
                                        <button class="btn btn-dark btn-sm copy-product"><i class="fas fa-copy"></i></button>
                                        <button class="btn btn-danger btn-sm delete-product"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group m-0">
                                        {{-- <select class="form-control @error('product_id') is-invalid @enderror" name="product_id" id="product_id" value="{{ old('product_id') }}">
                                            <option value="">{{ trans('quickadmin.order.fields.select_product') }}</option>
                                            @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select> --}}
                                        <div class="custom-select2">
                                            <div class="form-control-inner">
                                                <label>Products</label>
                                                <select class="js-example-basic-single" data-href="{{ route('products.create') }}" data-modal-target="productModal">
                                                    <option>Orange</option>
                                                    <option>White</option>
                                                    <option>Purple</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group m-0">
                                        <input type="text" class="form-control" min="0" name="quantity" value="{{ isset($order) ? $order->quantity : old('quantity') }}" id="quantity" autocomplete="true" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group m-0">
                                        <input type="text" class="form-control" min="0" name="price" value="{{ isset($order) ? $order->price : old('price') }}" id="price" autocomplete="true" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'">
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-group m-0">
                                        <input type="numeric" class="form-control" name="total_price" value="{{ isset($order) ? $order->total_price : old('total_price') }}" id="total_price" autocomplete="true" readonly>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <div class="custom-control custom-checkbox pt-4">
                                <input type="checkbox" class="custom-control-input" id="is_round_off">

                                <label class="custom-control-label" for="is_round_off">@lang('quickadmin.order.fields.round_off')</label>
                            </div>
                        </div>
                        <div class="col-lg-auto text-right">
                        <div class="invoice-detail-item mb-2">
                            <div class="d-flex align-items-center justify-content-between"><span class="invoice-detail-value">@lang('quickadmin.order.fields.thaila') : </span> <span class="px-2">
                            <input type="numeric" class="form-control form-control-sm col-md-3 float-right" id="thaila_price" name="thaila_price" value="0.00" min="0" step=".001">
                            </span></div>
                        </div>
                        <div class="invoice-detail-item mb-2">
                            <div class="d-flex align-items-center justify-content-between"><span class="invoice-detail-value">@lang('quickadmin.order.fields.sub_total_amount') : </span> <span class="px-2" id="sub_total_amount">0</span></div>
                        </div>
                        <div class="invoice-detail-item mb-2">
                            <div class="d-flex align-items-center justify-content-between"><span class="invoice-detail-value">@lang('quickadmin.order.fields.round_off') : </span> <span class="px-2" id="round_off_amount">0</span></div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <div class="invoice-detail-item mb-2">
                            <div class="d-flex align-items-center justify-content-between"><span class="invoice-detail-value">@lang('quickadmin.order.fields.grand_total') : </span> <span class="px-2" id="grand_total_amount">0</span></div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div><hr>
                <div class="row mt-4">
                    <div class="text-md-right">
                        <div class="float-lg-left">
                            <button type="submit" class="btn btn-success btn-icon icon-left saveInvoicebtn" id="saveInvoicebtn"><i class="fas fa-credit-card"></i>@lang('quickadmin.qa_save_invoice')</button>
                            {{-- <button class="btn btn-light btn-icon icon-left"><i class="fas fa-print"></i>@lang('quickadmin.qa_print_invoice')</button> --}}
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </form>
    </div>
  </section>
      <!-- Modal -->
{{-- <div class="modal fade" id="select2modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
</div> --}}

<div class="popup_render_div"></div>
@endsection

@section('customJS')
  @include('admin.order.partials.script')

<script>
    $(document).ready(function(){
        $(".js-example-basic-single").select2({
        }).on('select2:open', function () {
            let a = $(this).data('select2');
            if (!$('.select2-link').length) {
                a.$results.parents('.select2-results')
                    .append('<div class="select2-link2"><button class="btns addNewBtn" data-toggle="modal" data-target="#centerModal">Add New</button></div>');
            }
        });

        $(document).on('click', '.select2-container .addNewBtn', function (e) {
            //var hrefUrl = "{{ route('customers.create') }}";
            e.preventDefault();
            var gethis = $(this);
            console.log('test',$(this));
            var hrefUrl = $('.custom-select2').find('.js-example-basic-single').attr('data-href');
            var modalTarget = $('.custom-select2').find('select2').data('modal-target'); // Get the modal target
            console.log(hrefUrl);
            console.log(modalTarget);
            $.ajax({
                type: 'get',
                url: hrefUrl,
                dataType: 'json',
                success: function (response) {
                    //$('#preloader').css('display', 'none');
                    if(response.success) {
                        console.log('success');
                        $('.popup_render_div').html(response.htmlView);
                        $('#centerModal').modal('show');
                        //$("body").addClass("modal-open");
                    }
                }
            });

        });

        // $(document).on('click','.js-example-basic-single .addNewBtn', function(){
        // // $('#preloader').css('display', 'flex');
        //     var hrefUrl = "{{ route('customers.create') }}";
        //     console.log(hrefUrl);
        //     $.ajax({
        //         type: 'get',
        //         url: hrefUrl,
        //         dataType: 'json',
        //         success: function (response) {
        //             //$('#preloader').css('display', 'none');
        //             if(response.success) {
        //                 console.log('success');
        //                 $('.popup_render_div').html(response.htmlView);
        //                 $('#centerModal').modal('show');
        //             }
        //         }
        //     });
        // });
        // $(".modal-close,.modal-overlay").click(function(){
        //     $("body").removeClass("modal-open");
        // });
    });
</script>
@endsection
