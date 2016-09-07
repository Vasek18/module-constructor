<?php

namespace App\Helpers;

class vLang{

	public static function getAllPotentialPhrases($content){
		$phrases = [];

		$phrases = array_merge($phrases, static::getAllPotentialPhrasesInHtml($content));
		$phrases = array_merge($phrases, static::getAllPotentialPhrasesInPhp($content));
		$phrases = static::sortByOccurence($phrases);

		return $phrases;
	}

	private static function sortByOccurence($phrases){
		$size = count($phrases) - 1;
		for ($i = $size; $i >= 0; $i--){
			for ($j = 0; $j <= ($i - 1); $j++)
				if ($phrases[$j]["start_pos"] > $phrases[$j + 1]["start_pos"]){
					$k = $phrases[$j];
					$phrases[$j] = $phrases[$j + 1];
					$phrases[$j + 1] = $k;
				}
		}

		return $phrases;
	}

	private static function getAllPotentialPhrasesInHtml($content){
		$phrases = [];

		$phrases = array_merge($phrases, static::getAllPotentialPhrasesInHtmlBetweenTags($content));

		return $phrases;
	}

	private static function getAllPotentialPhrasesInHtmlBetweenTags($content){
		$textsBetweenTags = [];

		preg_match_all('/\>([^\<\>]+)\</is', $content, $matches);
		if (isset($matches[1])){
			foreach ($matches[1] as $match){
				$match = trim($match);
				if (!strlen($match)){
					continue;
				}
				$textsBetweenTags[] = [
					'phrase'     => $match,
					'start_pos'  => strpos($content, $match),
					'is_comment' => false,
					'code_type'  => 'html',
				];
			}
		}

		return $textsBetweenTags;
	}

	private static function getAllPotentialPhrasesInPhp($content){
		$phrases = [];

		$phrases = array_merge($phrases, static::getAllPotentialPhrasesInPhpVarsAssignment($content));
		$phrases = array_merge($phrases, static::getAllPotentialPhrasesInPhpComments($content));
		$phrases = static::testThatPhraseIsNotFunctionCall($phrases);

		return $phrases;
	}

	private static function getAllPotentialPhrasesInPhpVarsAssignment($content){
		$phrases = [];

		preg_match_all('/\<\?.*?=\s*?[\'\"]([^;\(\)]+)[\'\"]\s*?;/is', $content, $matches); // собираем присваивания
		if (isset($matches[1])){
			foreach ($matches[1] as $match){
				$match = trim($match);
				if (!strlen($match)){
					continue;
				}

				$phrases[] = [
					'phrase'     => $match,
					'start_pos'  => strpos($content, $match),
					'is_comment' => false,
					'code_type'  => 'php',
				];
			}
		}

		return $phrases;
	}

	private static function getAllPotentialPhrasesInPhpComments($content){
		$phrases = [];

		$phrases = array_merge($phrases, static::getAllPotentialPhrasesInPhpSingleComments($content));

		return $phrases;
	}

	private static function getAllPotentialPhrasesInPhpSingleComments($content){
		$phrases = [];

		preg_match_all('/\/\/(.+)$/m', $content, $matches);

		if (isset($matches[1])){
			foreach ($matches[1] as $match){
				$match = trim($match);
				if (!strlen($match)){
					continue;
				}
				$match = preg_replace('/(.+)\s*?\?\>/', '$1', $match); // убираем ? >, которое могло попасть
				$match = trim($match);

				$phrases[] = [
					'phrase'     => $match,
					'start_pos'  => strpos($content, $match),
					'is_comment' => true,
					'code_type'  => 'php',
				];
			}
		}

		return $phrases;
	}

	private static function testThatPhraseIsNotFunctionCall($phrases){
		$validatedPhrases = [];

		foreach ($phrases as $phrase){
			preg_match('/^[a-zA-Z_]+\(.*?\)/is', trim($phrase["phrase"]), $matches);
			if (count($matches)){
				continue;
			}

			$validatedPhrases[] = $phrase;
		}

		return $validatedPhrases;
	}
}