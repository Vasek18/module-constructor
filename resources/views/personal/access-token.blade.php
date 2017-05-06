@if (isset($_REQUEST['show_token']) && $_REQUEST['show_token'] == 'y')
    <h2>{{ trans('personal_cabinet.personal_info_api_key') }}</h2>
    <div class="row">
        @if ($user->tokens()->count())
            <div class="col-md-8">
                <input type="text"
                       class="form-control"
                       value="{{ $user->tokens()->first()->id }}"
                       disabled>
            </div>
        @else
            <div class="col-md-8">
                <input type="text"
                       class="form-control"
                       disabled>
            </div>
        @endif
        <div class="col-md-2">
            <a href="{{ action('PersonalController@getToken') }}"
               class="btn btn-primary btn-block">{{ trans('personal_cabinet.personal_info_generate_api_key') }}
            </a>
        </div>
    </div>
@endif