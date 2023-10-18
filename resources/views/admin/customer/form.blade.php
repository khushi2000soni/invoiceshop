<form>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">@lang('quickadmin.customers.fields.name')</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="name" value="{{ isset($customer) ? $customer->name : old('name') }}" id="name" autocomplete="true">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="guardian_name">@lang('quickadmin.customers.fields.guardian_name')</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="guardian_name" value="{{ isset($customer) ? $customer->guardian_name : old('guardian_name') }}" id="guardian_name" autocomplete="true">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">@lang('quickadmin.customers.fields.email')</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="email" value="{{ isset($customer) ? $customer->email : old('email') }}" id="email" autocomplete="true">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="phone">@lang('quickadmin.customers.fields.phone')</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="phone" value="{{ isset($customer) ? $customer->phone : old('phone') }}" id="phone" autocomplete="true">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="address_id">@lang('quickadmin.customers.fields.address')</label>
                <div class="input-group">
                    <select class="form-control @error('address_id') is-invalid @enderror" name="address_id" id="address_id" value="{{ isset($customer) ? $customer->address_id : old('address_id') }}">
                        <option value="{{ isset($customer) ? $customer->address->id : old('address_id') }}">
                            {{ isset($customer) ? $customer->address->address : old('address_id') }}
                        </option>

                        @foreach($addresses as $address)
                        <option value="{{ $address->id }}">{{ $address->address }}</option>
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
