<?php

namespace App\Helpers;

class vLang{

	public static function getAllPotentialPhrases($content){
		$phrases = [];

		$phrases = array_merge($phrases, static::getAllPotentialPhrasesInHtml($content));
		$phrases = array_merge($phrases, static::getAllPotentialPhrasesInPhp($content));

		return $phrases;
	}

	private static function getAllPotentialPhrasesInHtml($content){
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

		return $phrases;
	}

	private static function getAllPotentialPhrasesInPhpVarsAssignment($content){
		$phrases = [];

		preg_match_all('/=([^;]+);/is', $content, $matches);
		if (isset($matches[1])){
			foreach ($matches[1] as $match){
				$match = trim($match);
				if (!strlen($match)){
					continue;
				}
				if (substr($match, 0, 1) == '"'){
					$match = preg_replace('/^"(.+)"$/is', '$1', $match);
				}
				if (substr($match, 0, 1) == "'"){
					$match = preg_replace("/^'(.+)'$/is", '$1', $match);
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
				$match = preg_replace('/(.+)\s+?\?\>/', '$1', $match); // убираем ? >, которое могло попасть

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

}