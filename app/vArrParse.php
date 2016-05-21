<?php

namespace App;

class vArrParse{

	public function parseFromFile($file, $arrayName){
		$fileContent = file_get_contents($file);

		//dd($fileContent);
		return $this->parseFromText($fileContent, $arrayName);
	}

	public function parseFromText($text, $arrayName){
		$text = $this->normalizeText($text);
		$arrString = $this->getStringWithOnlyArrayBody($text, $arrayName);
		//dd($text);
		$array = $this->parseArrayFromPreparedString($arrString);

		//dd($array);

		return $array;
	}

	public function getStringWithOnlyArrayBody($text, $arrayName = '', $sub = false){
		// todo очистка от комментариев
		//
		//echo $text;
		//echo "<br>";

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
			//print_r($matches);
			//echo "<br>";
			if ($sub){
				if ($closingParenthesisPos = strpos($arrString, ')') !== false){
					$closingParenthesisPos = intval(strpos($arrString, ')'));
					//echo intval(strpos($arrString, ')')).' '.intval(strpos($arrString, '('));
					//echo "<br>";
					if ((strpos($arrString, '(') === false) || (intval(strpos($arrString, '(')) > intval($closingParenthesisPos))){ // случай когда мы захватили сестринский массив
						$arrString = substr($arrString, 0, $closingParenthesisPos);
					}
				}
			}
			//
			//echo $arrString;
			//echo "<br>";
			//echo "<br>";
			return $arrString;
		}

		return false;
	}

	protected function parseArrayFromPreparedString($arrString){
		//echo $arrString;
		//echo "<br>";
		$skip = 0;
		$array = [];
		$arrElsTemp = explode(',', $arrString);
		//print_r($arrElsTemp);
		//echo "<br>";

		foreach ($arrElsTemp as $c => $pair){
			//echo "<br>";
			//echo $skip;
			echo $pair;
			echo "<br>";
			if ($skip){
				$skip--;
				continue;
			}
			if (strpos($pair, '=>') != false){ // ассоциативный
				//echo $pair;
				//echo "<br>";
				$itemTemp = $this->explodeKeyAndValueFromStringOfAssiciativeArray($pair);
				//print_r($itemTemp);
				//echo "<br>";

				if (in_array($itemTemp['val'], ['Array()', 'array()'])){ // не используем нашу логику для пустого массива
					$array[$itemTemp['key']] = Array();
					continue;
				}
				if ($this->isValANewSubArrayStartstrPos($itemTemp['val'])){ // вложенный
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
			}else{
				if (strlen(trim($pair))){ // неассоциативный
					$array[] = $this->normalizeVal($pair);
				}
			}
		}

		return $array;
	}

	// вытащить из примерно такой строки ""CACHE_PATH" => "Y"" ключ и значение
	protected function explodeKeyAndValueFromStringOfAssiciativeArray($string){
		$key = null;
		$val = null;
		$itemTemp = explode('=>', $string);
		//print_r($itemTemp);
		//echo "<br>";
		$itemTemp[0] = str_replace('Array(', '', $itemTemp[0]); // мне не совсем понятно, когда актуальна эта строчка
		preg_match('/[\s\'\"]*([^\'\"]+)[\s\'\"]*/', $itemTemp[0], $keys);
		$key = $keys[1];
		//if ()

		$val = $this->normalizeVal($itemTemp[1]);

		return ['key' => $key, 'val' => $val];
	}

	protected function isValANewSubArrayStartstrPos($val){
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

	protected function normalizeText($text){
		$text = preg_replace('/\([\s,]+\)/', '()', $text);
		$text = preg_replace('/[\s,]+\)/', ')', $text);

		return $text;
	}

	protected function normalizeVal($val){
		$val = trim($val);
		if (substr($val, 0, 1) == '"' || substr($val, 0, 1) == "'"){ // если первый элемент ковычка
			preg_match('/[\s\'\"]+(.+)[\s\'\"]+/', $val, $vals);
		}else{
			preg_match('/[\s\'\"]*(.+)[\s\'\"]*/', $val, $vals);
		}
		if (isset($vals[1])){ // тупо чтобы на эксепшион не попасть
			$val = $vals[1];
		}

		return $val;
	}

}