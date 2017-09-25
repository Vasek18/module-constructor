<?php

// todo брать также public, static, ...

namespace App\Helpers;

class vFuncParse{

	public static function parseFromFile($file, $funcName){
		$fileContent = file_get_contents($file);

		return static::getFullCode($fileContent, $funcName);
	}

	public static function getStartPos($text, $funcName){
		$funcBeginning = static::getBeginningOfFunction($text, $funcName);
		return static::getBeginningPosOfFunction($text, $funcBeginning);
	}

	// переименовать в getFullCode
	public static function parseFromText($text, $funcName){
		$funcBeginning = static::getBeginningOfFunction($text, $funcName);
		if (!$funcBeginning){
			return false;
		}
		//dd($funcBeginning);

		$funcBeginningPos = static::getBeginningPosOfFunction($text, $funcBeginning);
		// dd($funcBeginningPos);
		$funcEndingPos = static::getEndingPosOfFunction($text, $funcBeginning, $funcBeginningPos);
		//dd($funcEndingPos);
		$functionString = static::extractFuncString($text, $funcBeginningPos, $funcEndingPos);

		return $functionString;
	}

	public static function getFullCode($text, $funcName){
		$funcBeginning = static::getBeginningOfFunction($text, $funcName);
		// dd($funcBeginning);
		$funcBeginningPos = static::getBeginningPosOfFunction($text, $funcBeginning);
		//dd($funcBeginningPos);
		$funcEndingPos = static::getEndingPosOfFunction($text, $funcBeginning, $funcBeginningPos);
		//dd($funcEndingPos);
		$functionString = static::extractFuncString($text, $funcBeginningPos, $funcEndingPos);

		return $functionString;
	}

	protected static function getBeginningOfFunction($text, $funcName){
		preg_match('/([\w\s]*)(function\s+'.$funcName.'\s*\([^\{]*\){)/is', $text, $matches);
		// dd($matches);
		if (isset($matches[2])){
			$modifs = '';
			if (strlen($matches[1])){
				$modifs = static::extractModifs($matches[1]);
				if (strlen($modifs)){
					$modifs .= ' ';
				}
			}

			return $modifs.$matches[2];
		}

		return false;
	}

	protected static function extractModifs($string){
		$legalModifs = ['private', 'protected', 'public', 'static'];

		$modifs = explode(' ', $string);
		foreach ($modifs as $c => $modif){
			if (!in_array($modif, $legalModifs)){
				unset($modifs[$c]);
			}
		}

		return implode(' ', $modifs);
	}

	protected static function getBeginningPosOfFunction($text, $funcBeginning){
		$beginning = strpos($text, $funcBeginning);
		if ($beginning !== false){
			return $beginning;
		}

		return false;
	}

	protected static function getEndingPosOfFunction($text, $funcBeginning, $funcBeginningPos){
		$text = substr($text, $funcBeginningPos + strlen($funcBeginning));
		//dd($text);

		$openBracketsC = 0;
		$endingBracketsC = 0;
		$pos = 0;
		$substr = '';
		while ($openBracketsC >= $endingBracketsC){
			$pos = strpos($text, '}', strlen($substr));
			//dd($pos);

			$substr = substr($text, 0, $pos + 1);
			//echo $substr;
			//echo '<br>';

			$openBracketsC = substr_count($substr, '{');
			$endingBracketsC = substr_count($substr, '}');
			//	//dd($openBracketsC." ".$endingBracketsC);
		}
		//dd($pos);
		//echo "<br>";

		//dd($text);

		return $pos + $funcBeginningPos + strlen($funcBeginning);
	}

	protected static function extractFuncString($text, $funcBeginningPos, $funcEndingPos){
		return substr($text, $funcBeginningPos, $funcEndingPos - $funcBeginningPos + 1);
	}

}