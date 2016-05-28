@extends('bitrix.internal_template')

@section('h1')
    Почтовое событие {{ $mail_event->name }} ({{ $mail_event->code }})
@stop

@section('page')
    <div class="col-md-4">
        <h2>Информация</h2>
        <form method="post"
              action="#"
              class="readonly">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label>Код</label>
                <p class="form-control-static">
                    <a href="#" class="you-can-change ajax" data-name="code">{{$mail_event->code}}</a>
                </p>
            </div>
            <div class="form-group">
                <label for="name">Название</label>
                <p class="form-control-static">
                    <a href="#" class="you-can-change ajax" data-name="name">{{$mail_event->name}}</a>
                </p>
            </div>
            <div class="form-group">
                <label for="sort">Сортировка</label>
                <p class="form-control-static">
                    <a href="#" class="you-can-change ajax" data-name="sort">{{$mail_event->sort}}</a>
                </p>
            </div>
            @if (count($mail_event->vars))
                <h3>Переменные</h3>
                @foreach($mail_event->vars as $var)
                    <div class="form-group row">
                        <div class="col-md-5">{{$var->code}}</div>
                        <div class="col-md-1">-</div>
                        <div class="col-md-5">{{$var->name}}</div>
                        <div class="col-md-1">
                            <a href="#"
                               class="btn btn-sm btn-danger">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
            <button type="submit" class="hidden">Сохранить</button>
        </form>
    </div>
    <div class="col-md-5 col-md-offset-1">
        <h2>Шаблоны</h2>
    </div>
    <div class="col-md-2">
        <br>
        <p>
            <a href="#"
               class="btn btn-sm btn-danger">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                Удалить событие
            </a>
        </p>
    </div>
@stop
