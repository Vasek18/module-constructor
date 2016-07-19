<div class="modal fade"
     tabindex="-1"
     role="dialog"
     id="modal_download_{{$module->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{ trans('bitrix.module_download') }}</h4>
            </div>
            <div class="modal-body">
                <form action="{{ action('Modules\Bitrix\BitrixController@download_zip', $module->id) }}"
                      method="POST">
                    <input type="hidden"
                           name="_token"
                           value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="version">{{ trans('app.version') }}</label>
                        <input class="form-control"
                               type="text"
                               name="version"
                               id="version"
                               required
                               value="{{upgradeVersionNumber($module->version)}}">
                    </div>
                    <button type="submit"
                            class="btn btn-primary"
                            name="module_download">{{ trans('app.download') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
