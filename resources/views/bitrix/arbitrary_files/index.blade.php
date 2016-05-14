@extends('bitrix.internal_template')

@section('h1')
    Произвольные файлы
@stop

@section('page')
    <div class="list-group">
        @foreach($files as $file)
            <div class="list-group-item clearfix file">
                <a href="#">{{$file->path}}{{$file->filename}}</a>
                <a href="#"
                   class="btn btn-danger pull-right">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </a>
            </div>
        @endforeach
    </div>
@stop