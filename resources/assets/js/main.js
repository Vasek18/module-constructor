// показ или скрытие лоадера
function loader(action, options){
	if (!action){
		action = 'show';
	}

	if (action == 'show'){
		// Добавляем оверлей
		if ($('#loader-overlay').length == 0){
			$('body').append('<div id="loader-overlay"></div>');
			$('body').css('overflow', 'hidden');
		}

		if ($('#loader').length == 0){
			// добавляем сам лоадер
			$('body').append('<div id="loader"></div>');
		}
	}

	if (action == 'hide'){
		// Удаляем оверлей
		$('#loader-overlay').detach();
		$('body').css('overflow', 'auto');

		// удаляем лоадер
		$('#loader').detach();
	}
}

function showLoader(options){
	loader('show', options);
}

function hideLoader(options){
	loader('hide', options);
}
