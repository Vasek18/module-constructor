@extends('app')

@section('content')
    <div class="container">
        <h1>{{ trans('oplata.h1') }}</h1>
        <p class="big-text">{{ trans('oplata.p1') }}</p>
        <p class="big-text">{!! trans('oplata.p2') !!}</p>
        <h2>{{ trans('oplata.h_actual_numbers') }}</h2>
        <div class="row">
            <div class="col-md-6">
                <table class="oplata-table table table-striped">
                    <tr>
                        <th>{{ trans('oplata.price') }}</th>
                        <td><kbd class="bg-primary">{{ convertCurrency(setting('day_price')) }}</kbd></td>
                    </tr>
                    <tr>
                        <th>{{ trans('oplata.demo_days') }}</th>
                        <td><kbd class="bg-primary">{{ setting('demo_days') }}</kbd></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@stop