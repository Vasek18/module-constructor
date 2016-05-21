<?php
function upgradeVersionNumber($version){
	$versionArr = explode(".", $version);
	$lastIndex = count($versionArr) - 1;
	$versionArr[$lastIndex]++;
	$version = implode(".", $versionArr);

	return $version;
}

// todo очистка от комментариев
function getPhpArrayFromFile($file, $arrayName){
	$fileContent = file_get_contents($file);
	//if (substr($arrayName, 0, 1) != '$'){ // todo это надо?
	//	$arrayName = '$'.$arrayName;
	//}

	$array = [];

	preg_match('/'.$arrayName.'\s*\=\s(?:array|Array)\((.+)\);/is', $fileContent, $matches); // массив внутри в таком случае не должен содержать ";"
	if ($matches[1]){ // вариант $arComponentDescription = array(
		$array = parseArrayFromString($matches[1]);

		//dd($arrElsTemp);
	}

	dd($array);
}

// todo пока не работает с вариантом, если за вложенным массивом есть ещё элементы
function parseArrayFromString($arrString){
	$array = [];
	$arrElsTemp = preg_split('/(?:,|\(\r)/i', $arrString);

	$subArrStarted = false;
	foreach ($arrElsTemp as $item){
		if ($subArrStarted){
			continue;
		}
		if (strpos($item, '=>') != false){ // ассоциативный
			$itemTemp = explodeKeyAndValueFromString($item);
			//print_r($itemTemp);

			if (strpos($itemTemp['val'], 'rray') === 1){ // вложенный
				$subArrStarted = true;
				$newArrString = substr($arrString, strpos($arrString, $item) + strlen($item));
				$array[$itemTemp['key']] = parseArrayFromString($newArrString, 2);
				continue;
			}

			$array[$itemTemp['key']] = $itemTemp['val'];
			continue;
		}
	}

	return $array;
}

// вытащить из примерно такой строки ""CACHE_PATH" => "Y"" ключ и значение
function explodeKeyAndValueFromString($string){
	$itemTemp = explode('=>', $string);
	preg_match('/[\s\'\"]*([^\'\"]+)[\s\'\"]*/', $itemTemp[0], $keys);
	$key = $keys[1];
	preg_match('/\s*(.+)\s*/', $itemTemp[1], $vals); // todo убирать кавычки по краям
	$val = $vals[1];

	return ['key' => $key, 'val' => $val];
}

?>