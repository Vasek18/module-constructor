<button class="btn btn-primary" data-toggle="modal" data-target="#create-template-modal">Создать шаблон</button>
<div class="modal fade" id="create-template-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{action('Modules\Bitrix\BitrixComponentsTemplatesController@store', [$module->id, $component->id])}}"
                  method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Создать шаблон</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="template_code">Код</label>
                        <input type="text" class="form-control" name="template_code" id="template_code" required>
                    </div>
                    <div class="form-group">
                        <label for="template_name">Название</label>
                        <input type="text" class="form-control" name="template_name" id="template_name">
                    </div>
                    <div class="form-group">
                        <label for="files">Файлы</label>
                        <input class="form-control" type="file" name="files" id="files" accept=".zip">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Создать</button>
                </div>
            </form>
        </div>
    </div>
</div>