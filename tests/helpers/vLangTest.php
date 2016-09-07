<?php

// todo
// значения массивов
// не все значения переменных - строки

use App\Helpers\vLang;

class vLangTest extends TestCase{
	/** @test */
	function it_finds_phrase_inside_html_tag(){
		$string = "<body>Ololo</body>";
		$expectedArr = [
			Array(
				'phrase'     => 'Ololo',
				'start_pos'  => 6,
				'is_comment' => false,
				'code_type'  => 'html',
			)
		];

		$gottenArr = vLang::getAllPotentialPhrases($string);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_finds_phrase_if_it_is_assigned_to_a_var_in_php(){
		$string = '<? $a = "Test";?>';
		$expectedArr = [
			Array(
				'phrase'     => 'Test',
				'start_pos'  => 9,
				'is_comment' => false,
				'code_type'  => 'php',
			)
		];

		$gottenArr = vLang::getAllPotentialPhrases($string);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_doesnt_get_number_if_it_is_assigned_to_a_var_in_php(){
		$string = '<? $a = 123;?>';
		$expectedArr = [];

		$gottenArr = vLang::getAllPotentialPhrases($string);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_doesnt_search_phrases_in_vars_if_its_not_in_php(){
		$string = 'src="<?"photo.jpg";?>"';
		$expectedArr = [];

		$gottenArr = vLang::getAllPotentialPhrases($string);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_doesnt_count_php_brackets_as_tag_brackets(){
		$string = '<img alt="<?=$arItem;?>" src="<?=$templateFolder;?>';
		$expectedArr = [];

		$gottenArr = vLang::getAllPotentialPhrases($string);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_finds_php_single_line_comments(){
		$string = '<? // ololo ?>';
		$expectedArr = [
			Array(
				'phrase'     => 'ololo',
				'start_pos'  => 6,
				'is_comment' => true,
				'code_type'  => 'php',
			)
		];

		$gottenArr = vLang::getAllPotentialPhrases($string);

		$this->assertEquals($expectedArr, $gottenArr);

		// и сразу ситуация без пробела
		$string = '<? // ololo?>';
		$expectedArr = [
			Array(
				'phrase'     => 'ololo',
				'start_pos'  => 6,
				'is_comment' => true,
				'code_type'  => 'php',
			)
		];

		$gottenArr = vLang::getAllPotentialPhrases($string);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function in_situation_clause_command_it_wont_fail(){
		$string = 'if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();';
		$expectedArr = [];

		$gottenArr = vLang::getAllPotentialPhrases($string);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function function_calls_is_not_possible_phrase(){
		$string = '// print_r(123) ?>';
		$expectedArr = [];

		$gottenArr = vLang::getAllPotentialPhrases($string);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function comments_are_cut_by_php_brackets(){
		$string = ' // todo брать у пользователя?>">';
		$expectedArr = [
			Array(
				'phrase'     => 'todo брать у пользователя',
				'start_pos'  => 4,
				'is_comment' => true,
				'code_type'  => 'php',
			)
		];

		$gottenArr = vLang::getAllPotentialPhrases($string);

		$this->assertEquals($expectedArr, $gottenArr);
	}
}

?>