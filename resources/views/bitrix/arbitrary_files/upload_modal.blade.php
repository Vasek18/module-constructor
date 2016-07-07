<div class="modal fade"
     tabindex="-1"
     role="dialog"
     id="upload-file">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{ trans('bitrix_arbitrary_files.file_upload_title') }}</h4>
            </div>
            <div class="modal-body">
                <form action=""
                      method="POST"
                      enctype="multipart/form-data">
                    <input type="hidden"
                           name="_token"
                           value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="path">{{ trans('bitrix_arbitrary_files.field_path') }}</label>
                        <input class="form-control"
                               type="text"
                               name="path"
                               id="path"
                               value="/"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="file">{{ trans('bitrix_arbitrary_files.field_file') }}</label>
                        <input class="form-control"
                               type="file"
                               name="file"
                               id="file"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="location">{{ trans('bitrix_arbitrary_files.field_location') }}</label>
                        <select name="location"
                                class="form-control"
                                id="location">
                            <option value="">{{ trans('app.select') }}</option>
                            <option value="in_module"
                                    selected>{{ trans('bitrix_arbitrary_files.in_module') }}</option>
                            <option value="on_site">{{ trans('bitrix_arbitrary_files.on_site') }}</option>
                        </select>
                    </div>
                    <button class="btn btn-primary"
                            name="upload">{{ trans('bitrix_arbitrary_files.button_upload') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>