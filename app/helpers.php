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
		$vArrParse = new App\vArrParse;
		$langVals = $vArrParse->parseFromFile($langfile, '$MESS');
		//dd($langVals);

		if (isset($langVals[$matches[1]])){
			//dd($langVals[$matches[1]]);
			return $langVals[$matches[1]];
		}else{
			return '';
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

?>