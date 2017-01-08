@push('scripts')
<script src="/js/bitrix_download_form.js"></script>
@endpush
<div class="modal fade"
     tabindex="-1"
     role="dialog"
     id="modal_download_{{$module->id}}">
    <div class="modal-dialog modal-lg">
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
                               value="{{ $module->download_counter ? upgradeVersionNumber($module->version) : $module->version}}">
                    </div>
                    <div class="form-group">
                        <label for="download_as">{{ trans('bitrix.download_as_new_or_update') }}</label>
                        <select class="form-control"
                                name="download_as"
                                id="download_as">
                            <option value="for_test"
                                    selected>{{ trans('bitrix.download_as_for_test') }}</option>
                            <option value="update">{{ trans('bitrix.download_as_update') }}</option>
                            <option value="fresh">{{ trans('bitrix.download_as_new') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="files_encoding">{{ trans('app.files_encoding') }}</label>
                        <select class="form-control"
                                name="files_encoding"
                                id="files_encoding">
                            <option value="utf-8">UTF-8</option>
                            <option value="windows-1251">windows-1251</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">{{ trans('bitrix.version_description') }}</label>
                        <textarea id="description"
                                  name="description"
                                  class="form-control"
                                  rows=10></textarea>
                    </div>
                    <div class="form-group">
                        <label for="updater">{{ trans('bitrix.updater') }}</label>
                        <textarea id="updater"
                                  name="updater"
                                  class="form-control"
                                  rows=10>{{ $module->generateUpdaterPhp() }}</textarea>
                    </div>
                    <button type="submit"
                            class="btn btn-primary btn-lg btn-block"
                            name="module_download">{{ trans('app.download') }}
                    </button>
                    <div class="files">
                        <h2>{{ trans('bitrix.changed_files') }}</h2>
                        <ul>
                            <?php $changedFiles = $module->getAllChangedOrNewFiles() ?>
                            @foreach($module->getListOfAllFiles() as $file)
                                <li>
                                    <label>
                                        <input type="checkbox"
                                               name="files[]"
                                               value="{{ $file }}"
                                        <?php if (in_array($file, $changedFiles) or in_array($file, $module::$requiredFiles)){
                                            echo "data-changed='true'";
                                            echo "checked";
                                        } ?>>
                                        {{$file}}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                        <a href="#"
                           class="check-all">{{ trans('app.check_all') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
