@extends("app")

@section("content")
    <div class="container">
        @include('personal.header')
        <h1>{{ trans('personal_cabinet.personal_info_h1') }}</h1>
        <div class="row">
            <form class="col-md-6">
                <div class="form-group">
                    <label for="email">{{ trans('personal_cabinet.personal_info_email') }}</label>
                    <input type="text"
                           id="email"
                           name="email"
                           class="form-control"
                           value="{{ $user->email }}"
                           disabled>
                </div>
                <div class="form-group">
                    <label for="NAME">{{ trans('personal_cabinet.personal_info_name') }}</label>
                    <input type="text"
                           id="NAME"
                           name="NAME"
                           class="form-control"
                           value="{{ $user->first_name }}"
                           required>
                </div>
                <div class="form-group">
                    <label for="SURNAME">{{ trans('personal_cabinet.personal_info_surname') }}</label>
                    <input type="text"
                           id="SURNAME"
                           name="SURNAME"
                           class="form-control"
                           value="{{ $user->last_name }}"
                           required>
                </div>
                <div class="form-group">
                    <label for="company_name">{{ trans('personal_cabinet.personal_info_company') }}</label>
                    <input type="text"
                           id="company_name"
                           name="company_name"
                           class="form-control"
                           value="{{ $user->bitrix_company_name }}"
                           required>
                </div>
                <div class="form-group">
                    <label for="bitrix_partner_code">{{ trans('personal_cabinet.personal_info_bitrix_partner_code') }}</label>
                    <input type="text"
                           id="bitrix_partner_code"
                           name="bitrix_partner_code"
                           class="form-control"
                           value="{{ $user->bitrix_partner_code }}"
                           required>
                </div>
                <div class="form-group">
                    <button id="edit"
                            name="edit"
                            class="btn btn-primary">{{ trans('app.edit') }}</button>
                </div>
            </form>
        </div>
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
                <div class="col-md-2">
                    <a href="{{ action('PersonalController@getToken') }}"
                       class="btn btn-primary btn-block">{{ trans('personal_cabinet.personal_info_generate_api_key') }}
                    </a>
                </div>
            @endif
        </div>
        <br> <br>
    </div>
@stop