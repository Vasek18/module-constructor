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
	}
}

?>