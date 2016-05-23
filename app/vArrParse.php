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
		$array = [];
		$arrElsTemp = $this->explodeOneLevelOfArrayInItems($arrString);
		//echo "<pre>";
		//print_r($arrElsTemp);
		//echo "</pre>";
		//echo "<br>";

		foreach ($arrElsTemp as $c => $pair){

			$itemTemp = $this->extractKeyAndValueFromString($pair);
			//echo "<pre>";
			//print_r($itemTemp);
			//echo "</pre>";
			//echo "<br>";

			//echo "<br>";
			//echo $skip;
			//echo $pair;
			//echo "<br>";
			//echo $pair;
			//echo "<br>";
			//$itemTemp = $this->explodeKeyAndValueFromStringOfAssiciativeArray($pair);
			//print_r($itemTemp);
			//echo "<br>";

			//if (in_array($itemTemp['val'], ['Array()', 'array()'])){ // не используем нашу логику для пустого массива
			//	$array[$itemTemp['key']] = Array();
			//	continue;
			//}
			if ($this->isValASubArray($itemTemp['val'])){ // вложенный
				$newArrString = $this->getStringWithOnlyArrayBody($itemTemp['val'], '', true);
				$array[$itemTemp['key']] = $this->parseArrayFromPreparedString($newArrString);

				continue;
			}

			//dd($array);

			if (isset($itemTemp['key'])){
				$array[$itemTemp['key']] = $itemTemp['val'];
			}else{
				$array[] = $itemTemp['val'];
			}
		}

		return $array;
	}

	// вытащить из примерно такой строки ""CACHE_PATH" => "Y"" ключ и значение
	protected function extractKeyAndValueFromString($string){
		$answer = [];
		$pair = explode('=>', $string, 2);

		if (count($pair) == 1){ // не ассоциативный
			$val = $pair[0];
		}else{
			$key = $pair[0];
			$val = $pair[1];
		}

		if (isset($key)){
			$key = $this->normalizeVal($key); // todo здесь, наверное другая функция нужна будет
			$answer['key'] = $key;
		}
		$val = $this->normalizeVal($val);
		$answer['val'] = $val;

		return $answer;
	}

	protected function isValASubArray($val){
		if (strpos($val, 'Array') === 0){
			if ($val == 'Array'){ // будем считать пустой массив не массивом
				return false;
			}
			return true;
		}
		if (strpos($val, 'array') === 0){
			if ($val == 'array'){ // будем считать пустой массив не массивом
				return false;
			}
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
			$val = substr($val, 1, strlen($val) - 2); // обрезаем по краям
			//$val = $this->normalizeVal($val);
		}

		return $val;
	}

	protected function explodeOneLevelOfArrayInItems($arrString){
		$items = [];

		while (strlen($arrString)){
			$offset = 0;
			$pos = strpos($arrString, ','); // находим разделитель
			if (!$pos){ // если не нашли разделитель, то это всё один элемент
				$pos = strlen($arrString);
			}
			$substr = substr($arrString, 0, $pos); // считаем элемент, всё что до него
			$opens = substr_count($substr, '('); // считаем открывающие скобки
			$closes = substr_count($substr, ')'); // считаем закрывающие скобки
			if ($opens > $closes){ // если открылся массив
				while ($opens > $closes){ // идём в цикле, пока не закроется
					if ($offset > strlen($arrString)){ // если произошло переполнение, то просто берём всю строку
						$pos = strlen($arrString);
						$substr = substr($arrString, 0, $pos);
						break;
					}
					$pos = strpos($arrString, ',', $offset);
					if (!$pos){ // если не нашли разделитель, то это всё один элемент
						$pos = strlen($arrString);
						$substr = substr($arrString, 0, $pos);
						break;
					}
					$substr = substr($arrString, 0, $pos);
					$opens = substr_count($substr, '(');// считаем открывающие скобки
					$closes = substr_count($substr, ')'); // считаем закрывающие скобки
					$offset += $pos + 1;
					//echo "<br>";
				}
				//dd($opens.' '.$closes);
				//echo "<br>";
			}
			//echo $substr;
			//echo "<br>";
			$items[] = $substr;
			$arrString = substr($arrString, $pos + 1); // убираем из исходной строки найденный элемент
		}

		return $items;
	}

}