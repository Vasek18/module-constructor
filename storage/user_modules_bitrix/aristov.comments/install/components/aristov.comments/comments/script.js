// todo без jquery
window.AristovComments                = (function(){
	this.ajaxPath = '/bitrix/components/aristov.comments/comments/ajax.php';
});
AristovComments.prototype.saveComment = function(authorName, text, parentID, iblockID, authorProp, parentProp){
	var ajaxArr = {
		authorName: authorName,
		text      : text,
		ava       : "/bitrix/components/aristov.comments/comments/templates/bootstrap/img/ava.jpg", // пока что так todo
		parentID  : parentID,
		iblockID  : iblockID,
		authorProp: authorProp,
		parentProp: parentProp,
		page      : location.href,
		action    : "add-comment",
		sessid    : BX.bitrix_sessid(),
		site_id   : BX.message('SITE_ID'),
	};

	$.post(this.ajaxPath, ajaxArr, function(answer){
		// console.log(ajaxArr);
		// console.log(answer);

		if (typeof saveCommentCallback !== 'undefined'){
			saveCommentCallback(answer);
		}
	}, "json");
};
$(document).on("keypress", ".ctrlEnterSubmit", function(e){
	var form    = $(this).parents('form');
	var keyCode = e.keyCode || e.charCode || e.which;
	if (keyCode == 10 || keyCode == 13){
		if (e.ctrlKey){
			$("form").submit();
		}
	}
});