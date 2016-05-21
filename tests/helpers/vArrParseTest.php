<?php

use App\vArrParse;

class vArrParseTest extends TestCase{

	protected $vArrParse;

	public function setUp(){
		parent::setUp();

		$this->vArrParse = new vArrParse();
	}

	/** @test */
	function it_gets_simple_associative_array_of_one_string_value(){
		$string =  "\$test = Array('ololo' => 'trololo');";
		$expectedArr = Array('ololo' => '\'trololo\'');

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');

		$this->assertEquals($gottenArr, $expectedArr);
	}
}

?>