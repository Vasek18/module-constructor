{{--модалка для подтвеждения удаления--}}
<div class="modal fade"
     id="delete-confirm-modal"
     tabindex="-1"
     role="dialog">
    <div class="modal-dialog"
         role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Удаление</h4>
            </div>
            <div class="modal-body">
                <p class="text">Уверены?</p>
            </div>
            <div class="modal-footer">
                <a type="button"
                   class="btn btn-danger delete">Всё-таки удалить
                </a>
            </div>
        </div>
    </div>
</div>