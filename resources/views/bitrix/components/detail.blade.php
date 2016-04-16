@extends('bitrix.internal_template')

@section('h1')
    Компонент
@stop

@section('page')
    <h2>Информация</h2>
    <dl>
        <dt>Название</dt>
        <dd>{{$component->name}}</dd>
        <dt>Код</dt>
        <dd>{{$component->code}}</dd>
        <dt>Описание</dt>
        <dd>{{$component->desc}}</dd>
        <dt>Сортировка</dt>
        <dd>{{$component->sort}}</dd>
    </dl>
    <h2>Путь в визуальном редакторе</h2>
    <div class="path">
        <form action="{{action('Modules\Bitrix\BitrixComponentsController@store_path', [$module->id, $component->id])}}"
              method="post">
            <div class="row">
                <div class="item col-md-3">
                    <h3>Уровень 1</h3>
                    <div class="form-group">
                        <input type="text" class="form-control" name="path_id_1" placeholder="Идентификатор" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="path_name_1" placeholder="Название" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="path_sort_1" placeholder="Сортировка" required>
                    </div>
                </div>
                <div class="item col-md-3">
                    <h3>Уровень 2</h3>
                    <div class="form-group">
                        <input type="text" class="form-control" name="path_id_2" placeholder="Идентификатор">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="path_name_2" placeholder="Название">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="path_sort_2" placeholder="Сортировка">
                    </div>
                </div>
                <div class="item col-md-3">
                    <h3>Уровень 3</h3>
                    <div class="form-group">
                        <input type="text" class="form-control" name="path_id_3" placeholder="Идентификатор">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="path_name_3" placeholder="Название">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="path_sort_3" placeholder="Сортировка">
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" name="store_path">Сохранить путь</button>
        </form>
    </div>
@stop
