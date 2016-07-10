<a href="#"
   class="btn btn-primary"
   data-toggle="modal"
   data-target="#upload_zip">{{ trans('bitrix_components.button_upload_zip') }}</a>
<div class="modal fade"
     tabindex="-1"
     role="dialog"
     id="upload_zip">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{ trans('bitrix_components.upload_zip_window_title') }}</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('upload_component_zip', $module->id) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    <input type="hidden"
                           name="_token"
                           value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="archive">{{ trans('bitrix_components.archive_field') }}</label>
                        <input class="form-control"
                               type="file"
                               name="archive"
                               id="archive"
                               required
                               accept=".zip">
                    </div>
                    <button class="btn btn-primary">{{ trans('bitrix_components.button_upload') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>