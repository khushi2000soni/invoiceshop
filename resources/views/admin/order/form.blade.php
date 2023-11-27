
    <div class="row">
        <div class="col-md-4">
             {{-- <div class="form-group">
                <label for="customer_id">@lang('quickadmin.order.fields.customer_name')</label>
                    <select class="form-control @error('customer_id') is-invalid @enderror" name="customer_id" id="customer_id"  value="{{ isset($order) ? $order->customer_id : old('customer_id') }}">
                        <option value="{{ isset($order) ? $order->customer->id : old('customer_id') }}">
                            {{ isset($order) ? $order->customer->name : trans('quickadmin.order.fields.select_customer') }}
                        </option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
            </div> --}}
            <div class="custom-select2">
                <div class="form-control-inner">
                    <label>@lang('quickadmin.order.fields.customer_name')</label>
                    <select class="js-example-basic-single @error('customer_id') is-invalid @enderror" name="customer_id" id="customer_id" >
                        <option value="{{ isset($order) ? $order->customer->id : old('customer_id') }}">
                            {{ isset($order) ? $order->customer->name : trans('quickadmin.order.fields.select_customer') }}
                        </option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
{{--
        <div class="col-md-6">
            <div class="form-group">
                <label for="product_id">@lang('quickadmin.order.fields.product_name')</label>
                <div class="input-group">
                    <select class="form-control @error('product_id') is-invalid @enderror" name="product_id" id="product_id" value="{{ old('product_id') }}">
                        <option value="">{{ trans('quickadmin.order.fields.select_product') }}</option>
                        @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="quantity">@lang('quickadmin.order.fields.quantity')</label>
                <div class="input-group">
                    <input type="text" class="form-control" min="0" name="quantity" value="{{ isset($order) ? $order->quantity : old('quantity') }}" id="quantity" autocomplete="true" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="price">@lang('quickadmin.order.fields.price')</label>
                <div class="input-group">
                    <input type="text" class="form-control" min="0" name="price" value="{{ isset($order) ? $order->price : old('price') }}" id="price" autocomplete="true" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'">
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="total_price">@lang('quickadmin.order.fields.sub_total')</label>
                <div class="input-group">
                    <input type="numeric" class="form-control" name="total_price" value="{{ isset($order) ? $order->total_price : old('total_price') }}" id="total_price" autocomplete="true" readonly>
                </div>
            </div>
        </div>

        <div class="col-md-1">
            <div class="form-group">
                <label for="total_price"></label>
                <div class="input-group pt-2">
                    <button type="button" class="btn btn-success" id="addProductBtn"><i class="fas fa-plus"></i></button>
                </div>
            </div>
        </div> --}}
    </div>


    {{-- <div class="custom-modal">
        <div class="modal-content">
            <button class="modal-close">X</button>
            <h2>Modal title</h2>
        </div>
    </div>
    <div class="modal-overlay"></div> --}}

