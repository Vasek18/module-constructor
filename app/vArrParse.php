<?php

namespace App;

class vArrParse{

	public function parseFromFile($file, $arrayName){
		$fileContent = file_get_contents($file);

		return $this->parseFromText($fileContent, $arrayName);
	}

	public function parseFromText($text, $arrayName){
		$text = $this->normalizeText($text);
		$arrString = $this->getStringWithOnlyArrayBody($text, $arrayName);
		$array = $this->parseArrayFromPreparedString($arrString);

		return $array;
	}

	public function getStringWithOnlyArrayBody($text, $arrayName = '', $sub = false){
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
			if ($sub){
				if ($closingParenthesisPos = strpos($arrString, ')') !== false){
					$closingParenthesisPos = intval(strpos($arrString, ')'));
					if ((strpos($arrString, '(') === false) || (intval(strpos($arrString, '(')) > intval($closingParenthesisPos))){ // случай когда мы захватили сестринский массив
						$arrString = substr($arrString, 0, $closingParenthesisPos);
					}
				}
			}

			return $arrString;
		}

		return false;
	}

	protected function parseArrayFromPreparedString($arrString){
		//echo $arrString;
		//echo "<br>";
		//echo "###";
		//echo "<br>";
		$array = [];
		$arrElsTemp = $this->explodeOneLevelOfArrayInItems($arrString);
		//echo "<pre>";
		//print_r($arrElsTemp);
		//echo "</pre>";
		//echo "<br>";

		foreach ($arrElsTemp as $c => $pair){
			//echo $pair;
			//echo "<br>";

			$itemTemp = $this->extractKeyAndValueFromString($pair);
			//echo "<pre>";
			//print_r($itemTemp);
			//echo "</pre>";
			//echo "<br>";

			if ($this->isValASubArray($itemTemp['val'])){ // вложенный
				//echo "<pre>";
				//print_r($itemTemp['val']);
				//echo "</pre>";
				//echo "<br>";
				$newArrString = $this->getStringWithOnlyArrayBody($itemTemp['val'], '', true);
				$itemTemp['val'] = $this->parseArrayFromPreparedString($newArrString);
			}

			if (isset($itemTemp['key'])){
				$array[$itemTemp['key']] = $itemTemp['val'];
			}else{
				$array[] = $itemTemp['val'];
			}
		}

		return $array;
	}

	protected function extractKeyAndValueFromString($string){
		$answer = [];

		$string = trim($string); // чтобы следующее условие не упало в случае ,{пробел}Array // todo вынести в normalize text
		if (stripos($string, 'Array(') === 0){ // если это строчка вида Array('a' => 'b')
			$val = $string;
		}else{
			$pair = explode('=>', $string, 2);

			if (count($pair) == 1){ // не ассоциативный
				$val = $pair[0];
			}else{
				$key = $pair[0];
				$val = $pair[1];
			}
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

	protected function normalizeText($text){
		// todo очистка от комментариев
		$text = preg_replace('/\([\s,]+\)/', '()', $text);
		$text = preg_replace('/[\s,]+\)/', ')', $text);

		return $text;
	}

	protected function normalizeVal($val){
		$val = trim($val);
		if (substr($val, 0, 1) == '"' || substr($val, 0, 1) == "'"){ // если первый элемент ковычка
			$val = substr($val, 1, strlen($val) - 2); // обрезаем по краям
		}

		return $val;
	}

	protected function explodeOneLevelOfArrayInItems($arrString){
		$items = [];

		while (strlen($arrString)){
			$pos = strpos($arrString, ','); // находим разделитель
			if (!$pos){ // если не нашли разделитель, то это всё один элемент
				$pos = strlen($arrString);
			}
			$substr = substr($arrString, 0, $pos); // считаем элементом, всё что до разделителя
			while ($this->isSubArrOpened($substr)){
				if ($pos >= strlen($arrString)){ // если произошло переполнение, то просто берём всю строку // todo этого быть не должно
					$pos = strlen($arrString);
					$substr = $arrString;
					break;
				}
				$pos = strpos($arrString, ',', $pos + 1);
				if (!$pos){ // если не нашли разделитель, то это всё один элемент
					$pos = strlen($arrString);
					$substr = $arrString;
					break;
				}
				$substr = substr($arrString, 0, $pos + 1);
			}
			$items[] = $substr;
			$arrString = substr($arrString, $pos + 1); // убираем из исходной строки найденный элемент
		}

		return $items;
	}

	protected function isSubArrOpened($string){
		$opens = substr_count($string, '('); // считаем открывающие скобки
		$closes = substr_count($string, ')'); // считаем закрывающие скобки

		if ($opens > $closes){
			return $opens - $closes;
		}

		return false;
	}

}