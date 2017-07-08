@extends("app")

@section("content")
    <div class="container">
        @include('personal.header')
        <h1>{{ trans('personal_cabinet.personal_info_h1') }}</h1>
        <div class="row">
            <form class="col-md-6"
                  action="{{ action('PersonalController@infoEdit') }}"
                  method="post">
                {{ csrf_field() }}
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
                    <label for="name">{{ trans('personal_cabinet.personal_info_name') }}</label>
                    <input type="text"
                           id="name"
                           name="name"
                           class="form-control"
                           value="{{ $user->first_name }}"
                           required>
                </div>
                <div class="form-group">
                    <label for="surname">{{ trans('personal_cabinet.personal_info_surname') }}</label>
                    <input type="text"
                           id="surname"
                           name="surname"
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
                    <label for="partner_code">{{ trans('personal_cabinet.personal_info_bitrix_partner_code') }}</label>
                    <input type="text"
                           id="partner_code"
                           name="partner_code"
                           class="form-control"
                           value="{{ $user->bitrix_partner_code }}"
                           required>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"
                                   name="personal_info_agreement"
                                   id="personal_info_agreement"
                                   checked
                                   required>
                            {!! trans('personal_cabinet.i_agree_with_personal_info_agreement', ['polzovatelskoe_soglashenie_link' => action('HtmlPagesController@personal_info_agreement'),'politika_konfidencialnosti_link' => action('HtmlPagesController@politika_konfidencialnosti')]) !!}
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <button id="edit"
                            name="edit"
                            class="btn btn-primary">{{ trans('app.edit') }}</button>
                </div>
            </form>
        </div>
        @include('personal.access-token')
        <br> <br>
    </div>
@stop