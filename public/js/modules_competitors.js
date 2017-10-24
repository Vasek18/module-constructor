// обновление обновлений модулей
$(document).on("click", ".js-check-competitors-updates", function(event){
	showLoader();

	var btn = $(this);

	// получаем массив аякс ссылок
	var ajaxLinks = [];
	$('[name="parse_updates_url[]"]').each(function(i, item){
		var link = $(item).val();
		ajaxLinks.push(link);
	});

	var ajaxCount    = 0;
	var ajaxTopCount = ajaxLinks.length;
	ajaxLinks.forEach(function(ajaxPath){
		$.ajax({
			url     : ajaxPath,
			data    : {},
			dataType: "json",
			type    : "get",
			success : function(answer){
				ajaxCount++;
				if (ajaxCount >= ajaxTopCount){
					location.reload();
				}
			},
			error   : function(){
				ajaxCount++;
				if (ajaxCount >= ajaxTopCount){
					location.reload();
				}

			}
		});
	});

	return false;
});