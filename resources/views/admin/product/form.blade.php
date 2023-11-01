<form>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name">@lang('quickadmin.product.fields.name')</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="name" value="{{ isset($product) ? $product->name : old('name') }}" id="name" autocomplete="true">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="category_id">@lang('quickadmin.product.fields.category_name')</label>
                <div class="input-group">
                    <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" id="category_id">
                        <option value="{{ isset($product) ? $product->category->id : old('category_id') }}">
                            {{ isset($product) ? $product->category->name : trans('quickadmin.product.select_category') }}
                        </option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">@lang('quickadmin.qa_submit')</button>
        </div>
    </div>
</form>
