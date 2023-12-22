
<tr class="template-row" style="display:none;">
    <td class="text-right">
        <div class="d-flex align-items-center buttonGroup justify-content-end">
            <button class="btn btn-dark btn-sm copy-product"><i class="fas fa-copy"></i></button>
            <button class="btn btn-danger btn-sm delete-product"><i class="fas fa-trash"></i></button>
        </div>
    </td>
    <td>
        <div class="form-group m-0">
            <div class="custom-select2 fullselect2">
                <div class="form-control-inner">
                    <select class="js-product-basic-single @error('product_id') is-invalid @enderror" name="product_id" id="product_id">
                        <option value="">{{ trans('quickadmin.order.fields.select_product') }}</option>
                        @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </td>
    <td>
        <div class="form-group m-0">
            <input type="number" class="form-control"  name="quantity" value="{{ isset($order) ? $order->quantity : old('quantity') }}" id="quantity" autocomplete="true" onkeydown="javascript: return ['Tab','NumpadDecimal','Period','Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'"  min="0" step=".01" >
        </div>
    </td>
    <td>
        <div class="form-group m-0">
            <input type="number" class="form-control" min="0" step=".01" name="price" value="{{ isset($order) ? $order->price : old('price') }}" id="price" autocomplete="true" onkeydown="javascript: return ['Tab','NumpadDecimal','Period', 'Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'">
        </div>
    </td>
    <td colspan="2">
        <div class="form-group m-0">
            <input type="number" class="form-control" name="total_price" value="{{ isset($order) ? $order->total_price : old('total_price') }}" id="total_price" autocomplete="true" min="0" step=".01"  readonly>
        </div>
    </td>
</tr>
