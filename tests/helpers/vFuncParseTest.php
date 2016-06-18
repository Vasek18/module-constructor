<?php

use App\Helpers\vFuncParse;

class vFuncParseTest extends TestCase{

	/** @test */
	function it_extracts_func_without_figure_breackets_in_it(){
		$string = 'ololo function DoInstall(){ echo "trololo"; } ololo ';
		$expectedFunc = 'function DoInstall(){ echo "trololo"; }';

		$gottenFunc = vFuncParse::parseFromText($string, 'DoInstall');

		//dd($gottenFunc);

		$this->assertEquals($expectedFunc, $gottenFunc);
	}

	/** @test */
	function it_extracts_empty_func(){
		$string = 'ololo function DoInstall(){} ololo ';
		$expectedFunc = 'function DoInstall(){}';

		$gottenFunc = vFuncParse::parseFromText($string, 'DoInstall');

		//dd($gottenFunc);

		$this->assertEquals($expectedFunc, $gottenFunc);
	}

	/** @test */
	function it_extracts_func_with_if_clause(){
		$string = 'ololo function DoInstall(){if(1){echo "ololo";}} ololo ';
		$expectedFunc = 'function DoInstall(){if(1){echo "ololo";}}';

		$gottenFunc = vFuncParse::parseFromText($string, 'DoInstall');

		//dd($gottenFunc);

		$this->assertEquals($expectedFunc, $gottenFunc);
	}

	/** @test */
	function it_extracts_func_with_if_clause_in_while_cycle(){
		$string = 'ololo function DoInstall(){while(1){if(1){echo "ololo";}}} ololo ';
		$expectedFunc = 'function DoInstall(){while(1){if(1){echo "ololo";}}}';

		$gottenFunc = vFuncParse::parseFromText($string, 'DoInstall');

		//dd($gottenFunc);

		$this->assertEquals($expectedFunc, $gottenFunc);
	}
}

?>