@extends('app')

@section('content')

    @include('bitrix.menu')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    @if ($module->id)
                        <div class="panel-heading">@yield('h1') | {{ trans('app.bitrix_module') }} "{{$module->name}}"
                            ({{$module->PARTNER_CODE}}.{{$module->code}})
                        </div>
                        <div class="panel-body">
                            @yield('page')
                        </div>
                    @else
                        <div class="panel-body">
                            {{ trans('app.error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop