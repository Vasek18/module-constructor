<div class="modal fade" tabindex="-1" role="dialog" id="upload-file">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span  aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Загрузка файла</h4>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="path">Путь</label>
                        <input class="form-control" type="text" name="path" id="path" value="/" required>
                    </div>
                    <div class="form-group">
                        <label for="file">Файл</label>
                        <input class="form-control" type="file" name="file" id="file" required>
                    </div>
                    <button class="btn btn-primary">Загрузить</button>
                </form>
            </div>
        </div>
    </div>
</div>