
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="customer_id">@lang('quickadmin.order.fields.customer_name')</label>
                <div class="input-group">
                    <select class="form-control @error('customer_id') is-invalid @enderror" name="customer_id" id="customer_id" value="{{ isset($order) ? $order->customer_id : old('customer_id') }}">
                        <option value="{{ isset($order) ? $order->customer->id : old('customer_id') }}">
                            {{ isset($order) ? $order->customer->name : old('customer_id') }}
                        </option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="product_id">@lang('quickadmin.order.fields.product_name')</label>
                <div class="input-group">
                    <select class="form-control @error('product_id') is-invalid @enderror" name="product_id" id="product_id" value="{{ isset($order) ? $order->product_id : old('product_id') }}">
                        <option value="{{ isset($order) ? $order->product->id : old('product_id') }}">
                            {{ isset($order) ? $order->product->name : old('product_id') }}
                        </option>
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
                    <input type="text" class="form-control" name="quantity" value="{{ isset($order) ? $order->quantity : old('quantity') }}" id="quantity" autocomplete="true">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="price">@lang('quickadmin.order.fields.price')</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="price" value="{{ isset($order) ? $order->price : old('price') }}" id="price" autocomplete="true">
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="total_price">@lang('quickadmin.order.fields.sub_total')</label>
                <div class="input-group">
                    <input type="numeric" class="form-control" name="total_price" value="{{ isset($order) ? $order->total_price : old('total_price') }}" id="pin" autocomplete="true">
                </div>
            </div>
        </div>

        <div class="col-md-1">
            <div class="form-group">
                <label for="total_price"></label>
                <div class="input-group pt-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i></button>
                </div>
            </div>
        </div>
    </div>

