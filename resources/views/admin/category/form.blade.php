
    <div class="form-group">
      <label>@lang('quickadmin.roles.fields.list.name')</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="fas fa-user"></i>
          </div>
        </div>
        <input type="text" class="form-control phone-number " name="name" value="{{ old('name') }}" id="name">
        @error('name')
            <div class="">

            </div>
        @enderror
      </div>
  </div>
  <button type="submit" class="btn btn-primary">Save</button>

