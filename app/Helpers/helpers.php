<?php
function upgradeVersionNumber($version){
	$versionArr = explode(".", $version);
	$lastIndex = count($versionArr) - 1;
	$versionArr[$lastIndex]++;
	$version = implode(".", $versionArr);

	return $version;
}

// todo это должно быть по идее в пространстве имён Битрикса
function extractLangVal($val, $langfile){
	preg_match('/GetMessage\([\"\']+([^\"\']+)/is', $val, $matches);
	if (isset($matches[1])){
		if (file_exists($langfile)){
			$vArrParse = new App\Helpers\vArrParse;
			$langVals = $vArrParse->parseFromFile($langfile, '$MESS');
			//dd($langVals);

			if (isset($langVals[$matches[1]])){
				//dd($langVals[$matches[1]]);
				return $langVals[$matches[1]];
			}else{
				return '';
			}
		}
	}

	return $val;
}

function ifStringIsValName($string){
	preg_match('/^\$([a-zA-Z_]+)/is', trim($string), $matches);
	if ($matches[0]){
		return true;
	}

	return false;
}

// todo это должно быть по идее в пространстве имён Битрикса
// todo создал в Битриксе getLangsArraysForFile
function getLangFilesForThisFile($root, $file){
	// todo захардкожен диск
	$answer = [];

	$dirs = \Storage::disk('user_modules_bitrix')->directories($root.'/lang');
	foreach ($dirs as $dir){
		$langFiles = \Storage::disk('user_modules_bitrix')->files($dir);
		foreach ($langFiles as $langFile){
			if ($dir.$file == $langFile){
				$dirPathArr = explode('/', $dir);
				$langKey = $dirPathArr[count($dirPathArr) - 1];

				$langFile = str_replace($root, '', $langFile);
				$answer[$langKey] = $langFile;
			}
		}
	}

	return $answer;
}

// используется в меню
function classActiveSegment($segment, $value){
	if (!is_array($value)){
		return Request::segment($segment) == $value ? ' active' : '';
	}
	foreach ($value as $v){
		if (Request::segment($segment) == $v) return ' active';
	}

	return '';
}

function translit($text){
	$accordance = [

		'а' => 'a',
		'б' => 'b',
		'в' => 'v',
		'г' => 'g',
		'д' => 'd',
		'е' => 'e',
		'ё' => 'yo',
		'ж' => 'g',
		'з' => 'z',
		'и' => 'i',
		'й' => 'y',
		'к' => 'k',
		'л' => 'l',
		'м' => 'm',
		'н' => 'n',
		'о' => 'o',
		'п' => 'p',
		'р' => 'r',
		'с' => 's',
		'т' => 't',
		'у' => 'u',
		'ф' => 'f',
		'х' => 'ch',
		'ц' => 'c',
		'ч' => 'ch',
		'ш' => 'sh',
		'щ' => 'sch',
		'ъ' => '',
		'ь' => '',
		'ы' => 'y',
		'э' => 'e',
		'ю' => 'yu',
		'я' => 'ya',
		'А' => 'A',
		'Б' => 'B',
		'В' => 'V',
		'Г' => 'G',
		'Д' => 'D',
		'Е' => 'E',
		'Ё' => 'YO',
		'Ж' => 'G',
		'З' => 'Z',
		'И' => 'I',
		'Й' => 'Y',
		'К' => 'K',
		'Л' => 'L',
		'М' => 'M',
		'Н' => 'N',
		'О' => 'O',
		'П' => 'P',
		'Р' => 'R',
		'С' => 'S',
		'Т' => 'T',
		'У' => 'U',
		'Ф' => 'F',
		'Х' => 'CH',
		'Ц' => 'C',
		'Ч' => 'CH',
		'Ш' => 'SH',
		'Щ' => 'SCH',
		'Ъ' => '',
		'Ь' => '',
		'Ы' => 'y',
		'Ю' => 'YU',
		'Я' => 'YA',
		'Э' => 'E',
		'#' => '',
		' ' => '_',
		'(' => '_',
		')' => '_',
		',' => '_',
		'!' => '_',
		'?' => '_',
		'/' => '_',
		'=' => '_',
		'<' => '_',
		'>' => '_',
		'"' => '_',
		"'" => '_',
	];

	foreach ($accordance as $search => $replace){
		$text = str_replace($search, $replace, $text);
	}
	$text = preg_replace('/__+/', '_', $text);
	$text = preg_replace('/^_*([^\_].*?[^\_])_*$/', '$1', $text);

	return $text;
}

function flash(){
	return app('App\Http\Flash');
}

// получить настройку
function setting($code, $default = null){
	$setting = \App\Models\Setting::where('code', $code)->first();

	if ($setting){
		return $setting->value;
	}else{
		return $default;
	}
}

function convertCurrency($price){
	$CP = new \App\Helpers\ConvertPrice;

	return $CP->convert($price);
}
