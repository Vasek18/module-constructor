<div class="modal fade" tabindex="-1" role="dialog" id="modal_delete_{{$module->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Удаление модуля</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">Вы уверены?</div>
                <form method="post"
                      action="{{ action('Modules\Bitrix\BitrixController@destroy', $module->id) }}"
                      class="readonly">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger">Удалить</button>
                </form>
            </div>
        </div>
    </div>
</div>