<?php

namespace App;

class vArrParse{

	public function parseFromFile($file, $arrayName){
		$fileContent = file_get_contents($file);

		//dd($fileContent);
		return $this->parseFromText($fileContent, $arrayName);
	}

	public function parseFromText($text, $arrayName){
		$arrString = $this->getStringWithOnlyArrayBody($text, $arrayName);
		//dd($arrString);
		$array = $this->parseArrayFromPreparedString($arrString);

		//dd($array);

		return $array;
	}

	public function getStringWithOnlyArrayBody($text, $arrayName = '', $sub = false){
		// todo очистка от комментариев

		$varEnding = ';';
		if ($sub){ // если вложенный массив
			$varEnding = '';
		}

		if ($arrayName){
			preg_match('/'.$arrayName.'\s*\=\s(?:array|Array)\((.+)\)'.$varEnding.'/is', $text, $matches);
		}else{
			preg_match('/(?:array|Array)\((.+)\)'.$varEnding.'/is', $text, $matches);
		}

		if (isset($matches[1])){
			$arrString = $matches[1];

			return $arrString;
		}

		return false;
	}

	protected function parseArrayFromPreparedString($arrString){
		$skip = 0;
		$array = [];
		$arrElsTemp = explode(',', $arrString);

		foreach ($arrElsTemp as $c => $pair){
			//echo $skip;
			//echo "<br>";
			//dd($pair);
			if ($skip){
				$skip--;
				continue;
			}
			if (strpos($pair, '=>') != false){ // ассоциативный
				$itemTemp = $this->explodeKeyAndValueFromStringOfAssiciativeArray($pair);

				if ($this->isValANewSubArrayStartstrpos($itemTemp['val'])){ // вложенный
					$newArrString = substr($arrString, strpos($arrString, $itemTemp['val']));
					//if (strpos($newArrString, '),')){ // обрезание массива в случае следующего сестринского
					//	$newArrString = substr($newArrString, 0, strpos($newArrString, '),')+1); // поскольку нам нужная скобка в функции дальше
					//}
					$newArrString = $this->getStringWithOnlyArrayBody($newArrString, '', true);
					$array[$itemTemp['key']] = $this->parseArrayFromPreparedString($newArrString);

					$skip = $this->countAssociativePairs($newArrString) - 1; // минус 1, потому что на этом шаге мы уже спарсили один ключ
					continue;
				}

				$array[$itemTemp['key']] = $itemTemp['val'];
				//dd($array);
			}
		}

		return $array;
	}

	// вытащить из примерно такой строки ""CACHE_PATH" => "Y"" ключ и значение
	protected function explodeKeyAndValueFromStringOfAssiciativeArray($string){
		$key = null;
		$val = null;
		$itemTemp = explode('=>', $string);
		preg_match('/[\s\'\"]*([^\'\"]+)[\s\'\"]*/', $itemTemp[0], $keys);
		$key = $keys[1];

		$itemTemp[1] = trim($itemTemp[1]);
		if (substr($itemTemp[1], 0, 1) == '"' || substr($itemTemp[1], 0, 1) == "'"){ // если первый элемент ковычка
			preg_match('/[\s\'\"]+(.+)[\s\'\"]+/', $itemTemp[1], $vals);
		}else{
			preg_match('/[\s\'\"]*(.+)[\s\'\"]*/', $itemTemp[1], $vals);
		}
		if (isset($vals[1])){ // тупо чтобы на эксепшион не попасть
			$val = $vals[1];
		}

		return ['key' => $key, 'val' => $val];
	}

	protected function isValANewSubArrayStartstrpos($val){
		if (strpos($val, 'rray') !== false){
			return true;
		}

		return false;
	}

	protected function countAssociativePairs($string){
		//if (substr_count($string, '=>')){
		//	dd($string);
		//}

		return substr_count($string, '=>');
	}

}