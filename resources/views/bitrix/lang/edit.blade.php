@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_lang.h1') }}
@stop

@section('page')

    <h2>{{ trans('bitrix_lang.edit_file') }} {{ $file }}</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="file-content">
                {!! $content !!}
            </div>
        </div>
        <div class="col-md-6">
            @if (count($phrases))
                <table class="table table-bordered">
                    @foreach($phrases as $c => $phrase)
                        <tr>
                            <td>{{ $c }}</td>
                            <td>{{ $phrase["phrase"] }}</td>
                            <td>
                                <input type="text" name="lang"></td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
@stop