<form action="{{ route('settings.update') }}" method="POST" id="settingform">
    <div class="row">
            <div class="col-md-12">
                @foreach ($settings as $setting)
                <div class="form-group">
                    <label for="{{ $setting->key }}">{{ $setting->display_name }}</label>
                    @if ($setting->type === 'image')
                        <input type="file" class="form-control" name="{{ $setting->key }}" value="{{ isset($settings) ? $setting->value : old($setting->value) }}" id="{{ $setting->key }}" autocomplete="true">
                    @elseif ($setting->type === 'number')
                        <input type="number" class="form-control" name="{{ $setting->key }}" value="{{ isset($settings) ? $setting->value : old($setting->value) }}" id="{{ $setting->key}}" autocomplete="true">
                    @else
                        <input type="text" class="form-control" name="{{ $setting->key }}" value="{{ isset($settings) ? $setting->value : old($setting->value) }}" id="{{ $setting->key}}" autocomplete="true">
                    @endif
                </div>
                @endforeach
            </div>

        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">@lang('quickadmin.qa_submit')</button>
        </div>
    </div>
</form>

