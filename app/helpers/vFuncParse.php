<?php

// todo не работает

namespace App\Helpers;

class vFuncParse{

	public function parseFromFile($file, $funcName){
		$fileContent = file_get_contents($file);

		return $this->parseFromText($fileContent, $funcName);
	}

	public function parseFromText($text, $funcName){
		$funcBeginning = $this->getBeginningOfFunction($text, $funcName);
		$funcBeginningPos = $this->getBeginningPosOfFunction($text, $funcBeginning);
		$funcEndingPos = $this->getEndingPosOfFunction($text, $funcBeginning, $funcBeginningPos);
		dd($funcEndingPos);
	}

	protected function getBeginningOfFunction($text, $funcName){
		preg_match('/(function\s+'.$funcName.'\s*\([^\{]*\){)/is', $text, $matches);
		if (isset($matches[1])){
			return $matches[1];
		}

		return false;
	}

	protected function getBeginningPosOfFunction($text, $funcBeginning){
		$beginning = strpos($text, $funcBeginning);
		if ($beginning !== false){
			return $beginning;
		}

		return false;
	}

	protected function getEndingPosOfFunction($text, $funcBeginning, $funcBeginningPos){
		$text = substr($text, $funcBeginningPos + strlen($funcBeginning));

		$openBracketsC = 0;
		$endingBracketsC = 0;
		$pos = 0;
		while ($openBracketsC >= $endingBracketsC){
			$pos = strpos($text, '}', $pos);
			$substr = substr($text, 0, $pos + 1);
			if ($pos > 203){
				dd($pos."  ###  ".$substr);
			}
			$openBracketsC = substr_count($substr, '{');
			$endingBracketsC = substr_count($substr, '}');
			//dd($openBracketsC." ".$endingBracketsC);
		}
		dd($substr);
		echo "<br>";

		dd($text);
	}

}