// создание комментария с формы
$(document).on("submit", ".av-comments .comment-form", function(event){
	var form     = $(this);
	var name     = form.find('[name=NAME]').val();
	var text     = form.find('[name=TEXT]').val();
	var parentID = form.find('[name=PARENT_ID]').val();

	var ac = new AristovComments;
	ac.saveComment(name, text, parentID);

	return false;
});
// обработчик добавления комментария
function saveCommentCallback(answer){
	if (answer.success){
		showMessage(answer.answer);
		$(".av-comments form").trigger('reset');
		// location.reload();
	}else{
		showMessage(answer.error_text);
	}
}
// показ модалки об успехе или ошибки
showMessage = function(text, time){
	// закрытие открытых окон
	$('.modal').modal('hide');

	var modal_window = '<div class="modal fade" id="comments-success" tabindex="-1" role="dialog" aria-hidden="true">' +
		'	<div class="modal-dialog">' +
		'		<div class="modal-content">' +
		'			<div class="modal-body">' +
		'				<p>' + text + '</p>' +
		'			</div>' +
		'		</div>' +
		'	</div>' +
		'</div>';

	if (time){
		$(modal_window).modal()
			.delay(time)
			.fadeOut(1000);
	}
	else{
		$(modal_window).modal();
	}
};
// поскольку нет подстановки аяксом, перезагружаем страницу
$(document).on('hide.bs.modal', '#comments-success', function(e){
	location.reload();
});