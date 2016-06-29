<?php

namespace App\Helpers;

// todo не работает, если в значении есть запятая
class vArrParse{

	public static function parseFromFile($file, $arrayName = ''){
		$fileContent = file_get_contents($file);

		return static::parseFromText($fileContent, $arrayName);
	}

	public static function parseFromText($text, $arrayName = ''){
		$text = static::normalizeText($text);
		if ($arrayName){
			$arrayName = static::validateArrayName($arrayName);
			$text = static::transformAllPartsOfArrToANormalAndJointForm($text, $arrayName);
			//dd($text);
		}
		$arrString = static::getStringWithOnlyArrayBody($text, $arrayName);
		// dd($arrString);
		$array = static::parseArrayFromPreparedString($arrString);

		return $array;
	}

	protected static function validateArrayName($arrayName){
		$arrayName = str_replace('$', '', $arrayName);

		return $arrayName;
	}

	protected static function transformAllPartsOfArrToANormalAndJointForm($text, $arrayName){
		// нормальной будем считать форму $arr = Array('key' => 'value')

		if ($arrayName){
			preg_match_all('/'.$arrayName.'\s*\[[\"\']*([^\"\']+)[\"\']*\]\s*\=\s*([^;]+);/is', $text, $matches);
		}

		if (count($matches[1]) && count($matches[2])){ // типа такого test["ololo"] = "trololo";
			//dd($matches);
			$arrString = $arrayName.' = Array(';
			foreach ($matches[1] as $c => $match){
				$arrString .= '"'.$match.'" => '.$matches[2][$c];
				if (isset($matches[2][$c + 1])){
					$arrString .= ',';
				}
			}
			$arrString .= ');';

			return $arrString;
		}

		return $text;
	}

	public static function getStringWithOnlyArrayBody($text, $arrayName = '', $sub = false){
		// проверка на лишние закрывающие скобочки
		$openParenthesisCount = substr_count($text, '(');
		$closeParenthesisCount = substr_count($text, ')');
		if ($closeParenthesisCount > $openParenthesisCount){
			$text = substr($text, 0, strripos($text, ')'));
			static::getStringWithOnlyArrayBody($text, $arrayName, $sub);
		}

		//echo $text;
		$varEnding = ';';
		if (strpos($text, $varEnding) === false){ // на случай поиска массива, например, в вызове функции
			$varEnding = '';
		}
		if ($sub){ // если вложенный массив
			$varEnding = '';
		}

		if ($arrayName){
			preg_match('/'.$arrayName.'\s*\=\s*(?:array|Array)\(([^\;]+)\)'.$varEnding.'/is', $text, $matches);
		}else{
			//dd($text);
			preg_match('/(?:array|Array)\((.+)\)'.$varEnding.'/is', $text, $matches);
		}

		//dd($matches);

		if (isset($matches[1])){
			$arrString = $matches[1];

			if ($sub || !$arrayName){
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

	protected static function parseArrayFromPreparedString($arrString){
		//echo $arrString;
		//echo "<br>";
		//echo "###";
		//echo "<br>";
		$array = [];
		$arrElsTemp = static::explodeOneLevelOfArrayInItems($arrString);
		//echo "<pre>";
		//print_r($arrElsTemp);
		//echo "</pre>";
		//echo "<br>";

		foreach ($arrElsTemp as $c => $pair){
			//echo $pair;
			//echo "<br>";

			$itemTemp = static::extractKeyAndValueFromString($pair);
			//echo "<pre>";
			//print_r($itemTemp);
			//echo "</pre>";
			//echo "<br>";

			if (static::isValASubArray($itemTemp['val'])){ // вложенный
				//echo "<pre>";
				//print_r($itemTemp['val']);
				//echo "</pre>";
				//echo "<br>";
				$newArrString = static::getStringWithOnlyArrayBody($itemTemp['val'], '', true);
				$itemTemp['val'] = static::parseArrayFromPreparedString($newArrString);
			}

			if (isset($itemTemp['key'])){
				$array[$itemTemp['key']] = $itemTemp['val'];
			}else{
				$array[] = $itemTemp['val'];
			}
		}

		return $array;
	}

	protected static function extractKeyAndValueFromString($string){
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
			$key = static::normalizeVal($key); // todo здесь, наверное другая функция нужна будет
			$answer['key'] = $key;
		}
		$val = static::normalizeVal($val);
		$answer['val'] = $val;

		return $answer;
	}

	protected static function isValASubArray($val){
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

	protected static function normalizeText($text){
		// todo очистка от комментариев
		$text = preg_replace('/\([\s,]+\)/', '()', $text);
		$text = preg_replace('/[\s,]+\)/', ')', $text);

		return $text;
	}

	protected static function normalizeVal($val){
		$val = trim($val);
		if (substr($val, 0, 1) == '"' || substr($val, 0, 1) == "'"){ // если первый элемент ковычка
			$val = substr($val, 1, strlen($val) - 2); // обрезаем по краям
		}

		return $val;
	}

	protected static function explodeOneLevelOfArrayInItems($arrString){
		$items = [];

		while (strlen($arrString)){
			$pos = strpos($arrString, ','); // находим разделитель
			if (!$pos){ // если не нашли разделитель, то это всё один элемент
				$pos = strlen($arrString);
			}
			$substr = substr($arrString, 0, $pos); // считаем элементом, всё что до разделителя
			while (static::isSubArrOpened($substr)){
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

	protected static function isSubArrOpened($string){
		$opens = substr_count($string, '('); // считаем открывающие скобки
		$closes = substr_count($string, ')'); // считаем закрывающие скобки

		if ($opens > $closes){
			return $opens - $closes;
		}

		return false;
	}

}