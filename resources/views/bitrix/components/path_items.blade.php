<div id="path_items">
    <h2>Путь в визуальном редакторе</h2>
    <div class="path">
        <form action="{{action('Modules\Bitrix\BitrixComponentsController@store_path', [$module->id, $component->id])}}"
              method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="item col-md-3">
                    <h3>Уровень 1</h3>
                    <div class="form-group">
                        <input type="text" class="form-control" name="path_id_1" placeholder="Идентификатор"
                               value="{{isset($path_items[0]) ? $path_items[0]->code : ''}}" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="path_name_1" placeholder="Название"
                               value="{{isset($path_items[0]) ? $path_items[0]->name : ''}}" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="path_sort_1" placeholder="Сортировка"
                               value="{{isset($path_items[0]) ? $path_items[0]->sort : ''}}" required>
                    </div>
                </div>
                <div class="item col-md-3">
                    <h3>Уровень 2</h3>
                    <div class="form-group">
                        <input type="text" class="form-control" name="path_id_2" placeholder="Идентификатор"
                               value="{{isset($path_items[1]) ? $path_items[1]->code : ''}}">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="path_name_2" placeholder="Название"
                               value="{{isset($path_items[1]) ? $path_items[1]->name : ''}}">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="path_sort_2" placeholder="Сортировка"
                               value="{{isset($path_items[1]) ? $path_items[1]->sort : ''}}">
                    </div>
                </div>
                <div class="item col-md-3">
                    <h3>Уровень 3</h3>
                    <div class="form-group">
                        <input type="text" class="form-control" name="path_id_3" placeholder="Идентификатор"
                               value="{{isset($path_items[2]) ? $path_items[2]->code : ''}}">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="path_name_3" placeholder="Название"
                               value="{{isset($path_items[2]) ? $path_items[2]->name : ''}}">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="path_sort_3" placeholder="Сортировка"
                               value="{{isset($path_items[2]) ? $path_items[2]->sort : ''}}">
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" name="store_path">Сохранить путь</button>
        </form>
    </div>
</div>