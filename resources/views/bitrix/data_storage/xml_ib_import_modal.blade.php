<div class="modal fade"
     tabindex="-1"
     role="dialog"
     id="import_xml">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{ trans('bitrix_data_storage.xml_ib_import_title') }}</h4>
            </div>
            <div class="modal-body">
                <form action="{{ action('Modules\Bitrix\BitrixDataStorageController@xml_ib_import', ['module' => $module]) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    <input type="hidden"
                           name="_token"
                           value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="version">{{ trans('app.file') }}</label>
                        <input class="form-control"
                               type="file"
                               name="file"
                               id="file"
                               required>
                    </div>
                    <button type="submit"
                            class="btn btn-primary"
                            name="import">{{ trans('app.import') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
