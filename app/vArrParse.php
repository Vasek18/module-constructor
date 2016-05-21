<?php

namespace App;

class vArrParse{

	public function parseFromFile($file, $arrayName){
		$this->getPhpArrayFromFile($file, $arrayName);
	}

	public function parseFromText($text, $arrayName){
		$array = [];

		preg_match('/'.$arrayName.'\s*\=\s(?:array|Array)\((.+)\);/is', $text, $matches); // массив внутри в таком случае не должен содержать ";"
		if ($matches[1]){ // вариант $arComponentDescription = array(
			$array = $this->parseArrayFromPreparedString($matches[1]);

			//dd($arrElsTemp);
		}

		return $array;
	}

	// todo очистка от комментариев
	public function getPhpArrayFromFile($file, $arrayName){
		$fileContent = file_get_contents($file);
		//if (substr($arrayName, 0, 1) != '$'){ // todo это надо?
		//	$arrayName = '$'.$arrayName;
		//}

		$array = [];

		preg_match('/'.$arrayName.'\s*\=\s(?:array|Array)\((.+)\);/is', $fileContent, $matches); // массив внутри в таком случае не должен содержать ";"
		if ($matches[1]){ // вариант $arComponentDescription = array(
			$array = $this->parseArrayFromPreparedString($matches[1]);

			//dd($arrElsTemp);
		}

		return $array;
	}

	// todo пока не работает с вариантом, если за вложенным массивом есть ещё элементы
	protected function parseArrayFromPreparedString($arrString){
		$array = [];
		$arrElsTemp = preg_split('/(?:,|\(\r)/i', $arrString);

		$subArrStarted = false;
		foreach ($arrElsTemp as $c => $item){
			//echo $c.' ### '.$item;
			//echo "<br>";
			if ($subArrStarted){
				if (strpos($item, '\'') === false && strpos($item, '\"') === false){ // типа нет ключа
					if (strpos($item, ')') !== false){
						$subArrStarted = false;
					}
				}
				continue;
			}
			if (strpos($item, '=>') != false){ // ассоциативный
				$itemTemp = $this->explodeKeyAndValueFromString($item);
				//print_r($itemTemp);

				if (strpos($itemTemp['val'], 'rray') === 1){ // вложенный
					$subArrStarted = true;
					$newArrString = substr($arrString, strpos($arrString, $item) + strlen($item));
					$array[$itemTemp['key']] = $this->parseArrayFromPreparedString($newArrString, 2);
					continue;
				}

				$array[$itemTemp['key']] = $itemTemp['val'];
				continue;
			}
		}

		return $array;
	}

	// вытащить из примерно такой строки ""CACHE_PATH" => "Y"" ключ и значение
	protected function explodeKeyAndValueFromString($string){
		$itemTemp = explode('=>', $string);
		preg_match('/[\s\'\"]*([^\'\"]+)[\s\'\"]*/', $itemTemp[0], $keys);
		$key = $keys[1];
		preg_match('/\s*(.+)\s*/', $itemTemp[1], $vals); // todo убирать кавычки по краям
		$val = $vals[1];

		return ['key' => $key, 'val' => $val];
	}

}