<div class="modal fade"
     tabindex="-1"
     role="dialog"
     id="edit-file_{{$i}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{ trans('bitrix_arbitrary_files.file_edit_title') }}</h4>
            </div>
            <div class="modal-body">
                <form action="{{ action('Modules\Bitrix\BitrixArbitraryFilesController@update', [$module->id, $file->id]) }}"
                      method="POST">
                    <input type="hidden"
                           name="_token"
                           value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="filename_{{$file->id}}">{{ trans('bitrix_arbitrary_files.field_name') }}</label>
                        <input class="form-control"
                               type="text"
                               name="filename_{{$file->id}}"
                               id="filename_{{$file->id}}"
                               value="{{$file->filename}}"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="path_{{$file->id}}">{{ trans('bitrix_arbitrary_files.field_path') }}</label>
                        <input class="form-control"
                               type="text"
                               name="path_{{$file->id}}"
                               id="path_{{$file->id}}"
                               value="{{$file->path}}"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="location_{{$file->id}}">{{ trans('bitrix_arbitrary_files.field_location') }}</label>
                        <select name="location_{{$file->id}}"
                                class="form-control"
                                id="location_{{$file->id}}">
                            <option value="in_module"
                                    @if ($file->location == 'in_module') selected @endif>{{ trans('bitrix_arbitrary_files.in_module') }}</option>
                            <option value="on_site"
                                    @if ($file->location == 'on_site') selected @endif>{{ trans('bitrix_arbitrary_files.on_site') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div id="editor_{{$file->id}}"
                             style="height: 500px">{{ html_entity_decode($file->code) }}</div>
                        @push('scripts')
                        <script>
                            var editor_{{$file->id}}   = ace.edit("editor_{{$file->id}}");
                            editor_{{$file->id}}.getSession().setMode("ace/mode/php");
                            editor_{{$file->id}}.getSession().on('change', function(){
                                var text = editor_{{$file->id}}.getSession().getValue();
//                                console.log(text);
                                $("#code_{{$file->id}}").val(text);
                            });
                        </script>
                        @endpush
                        <input type="hidden"
                               name="code_{{$file->id}}"
                               id="code_{{$file->id}}"
                               value="{{ html_entity_decode($file->code) }}">
                    </div>
                    <button class="btn btn-primary"
                            name="save_{{$file->id}}">{{ trans('app.save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>