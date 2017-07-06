@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('reg.title') }}</div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>{{trans('validation.error')}}</strong> {{trans('validation.there_occur_errors')}}
                                <br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form-horizontal"
                              role="form"
                              method="POST"
                              action="{{ action('Auth\RegisterController@register') }}">
                            <input type="hidden"
                                   name="_token"
                                   value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('reg.name') }}</label>
                                <div class="col-md-6">
                                    <input type="text"
                                           class="form-control"
                                           name="first_name"
                                           value="{{ old('first_name') }}"
                                           required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('reg.surname') }}</label>
                                <div class="col-md-6">
                                    <input type="text"
                                           class="form-control"
                                           name="last_name"
                                           value="{{ old('last_name') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('reg.email') }}</label>
                                <div class="col-md-6">
                                    <input type="email"
                                           class="form-control"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required>
                                </div>
                            </div>
                            {{--<div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('reg.company_name') }}</label>
                                <div class="col-md-6">
                                    <input type="text"
                                           class="form-control"
                                           name="company_name"
                                           value="{{ old('company_name') }}">
                                </div>
                            </div>--}}
                            {{-- <div class="form-group">
                                 <label class="col-md-4 control-label">{{ trans('reg.company_site') }}</label>
                                 <div class="col-md-6">
                                     <input type="url"
                                            class="form-control"
                                            name="site"
                                            value="{{ old('site') }}">
                                 </div>
                             </div>--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('reg.password') }}</label>
                                <div class="col-md-6">
                                    <input type="password"
                                           class="form-control"
                                           name="password"
                                           required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('reg.password_conf') }}</label>
                                <div class="col-md-6">
                                    <input type="password"
                                           class="form-control"
                                           name="password_confirmation">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <div class="col-md-6 col-md-offset-4">
                                        <label>
                                            <input type="checkbox"
                                                   name="personal_info_agreement"
                                                   id="personal_info_agreement"
                                                   checked
                                                   required>
                                            {!! trans('reg.i_agree_with_personal_info_agreement', ['polzovatelskoe_soglashenie_link' => action('HtmlPagesController@personal_info_agreement'),'politika_konfidencialnosti_link' => action('HtmlPagesController@politika_konfidencialnosti')]) !!}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit"
                                            class="btn btn-primary"
                                            name="signup">{{ trans('reg.submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection