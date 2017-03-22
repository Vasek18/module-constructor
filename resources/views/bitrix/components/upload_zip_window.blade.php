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
                    <div class="form-group">
                        <label for="namespace">{{ trans('bitrix_components.archive_namespace') }}</label>
                        <input type="text"
                               id="namespace"
                               name="namespace"
                               class="form-control"
                               value="{{ $module->full_id }}"
                               required>
                    </div>
                    <div class="clearfix">
                        <button class="btn btn-primary"
                                name="upload">{{ trans('bitrix_components.button_upload') }}</button>
                    </div>
                    <br>
                    <p>
                        {!! trans('bitrix_components.upload_desc') !!}
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>