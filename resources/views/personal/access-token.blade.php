@if (isset($_REQUEST['show_token']) && $_REQUEST['show_token'] == 'y')
    <h2>{{ trans('personal_cabinet.personal_info_api_key') }}</h2>
    <div class="row">
        <div class="col-md-12">
            @if(session()->has('api_token'))
                <textarea class="form-control"
                          rows="10">{{ session('api_token') }}</textarea>
            @endif
        </div>
        <div class="col-md-12">
            <a href="{{ action('PersonalController@getToken') }}"
               class="btn btn-primary btn-lg">{{ trans('personal_cabinet.personal_info_generate_api_key') }}
            </a>
        </div>
    </div>
@endif