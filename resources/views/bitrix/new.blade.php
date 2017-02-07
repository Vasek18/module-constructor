@extends('app')

@push('scripts')
<script src="/js/bitrix_create_form.js"></script>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{trans('bitrix_create.form_title')}}</div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>{{trans('validation.error')}}</strong> {{trans('validation.there_occur_errors')}}:<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ action('Modules\Bitrix\BitrixController@store') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-md-4 control-label">{{trans('bitrix_create.module_name_label')}}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="MODULE_NAME"
                                           value="{{ old('MODULE_NAME') }}" required aria-describedby="MODULE_NAME_help"
                                           id="module_name">
                                    <span class="help-block"
                                          id="MODULE_NAME_help">{!!trans('bitrix_create.module_name_help')!!}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">{{trans('bitrix_create.module_desc_label')}}</label>
                                <div class="col-md-6">
                                    <textarea name="MODULE_DESCRIPTION" class="form-control"
                                              aria-describedby="MODULE_DESCRIPTION_help">{{ old('MODULE_DESCRIPTION') }}</textarea>
                                    <span class="help-block"
                                          id="MODULE_DESCRIPTION_help">{!!trans('bitrix_create.module_desc_help')!!}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">{{trans('bitrix_create.module_code_label')}}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="MODULE_CODE"
                                           value="{{ old('MODULE_CODE') }}" required pattern="[a-z]+[a-z0-9]*"
                                           aria-describedby="MODULE_CODE_help" data-translit_from="module_name"
                                           id="module_code">
                                    <span class="help-block"
                                          id="MODULE_CODE_help">{!!trans('bitrix_create.module_code_help')!!}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">{{trans('bitrix_create.module_version_label')}}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="MODULE_VERSION"
                                           value="0.0.1" required pattern="[0-9\.]+"
                                           aria-describedby="MODULE_VERSION_help">
                                    <span class="help-block"
                                          id="MODULE_VERSION_help">{!!trans('bitrix_create.module_version_help')!!}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">{{trans('bitrix_create.partner_name_label')}}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="PARTNER_NAME"
                                           value="{{ $user["bitrix_company_name"]?$user["bitrix_company_name"]:$user["company_name"] }}"
                                           required aria-describedby="PARTNER_NAME_help">
                                    <span class="help-block"
                                          id="PARTNER_NAME_help">{!!trans('bitrix_create.partner_name_help')!!}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">{{trans('bitrix_create.partner_uri_label')}}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="PARTNER_URI"
                                           required value="{{ $user["site"] }}" aria-describedby="PARTNER_URI_help">
                                    <span class="help-block"
                                          id="PARTNER_URI_help">{!!trans('bitrix_create.partner_uri_help')!!}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">{{trans('bitrix_create.partner_code_label')}}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="PARTNER_CODE"
                                           value="{{ $user["bitrix_partner_code"] }}" required pattern="[a-z]+[a-z0-9]*"
                                           aria-describedby="PARTNER_CODE_help">
                                    <span class="help-block"
                                          id="PARTNER_CODE_help">{!!trans('bitrix_create.partner_code_help')!!}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary"
                                            name="module_create">{{trans('bitrix_create.button')}}</button>
                                </div>
                            </div>
                        </form>
                        <div class="step-description">
                            <h2>{{trans('bitrix_create.form_desc_title')}}</h2>
                            <p>{{trans('bitrix_create.form_desc_text')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop