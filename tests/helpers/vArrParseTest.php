<?php

use App\vArrParse;

class vArrParseTest extends TestCase{

	protected $vArrParse;

	public function setUp(){
		parent::setUp();

		$this->vArrParse = new vArrParse();
	}

	/** @test */
	function it_gets_associative_array_in_one_line_starting_with_array_and_contains_one_string_value(){
		$string = "\$test = Array('ololo' => 'trololo');";
		$expectedArr = Array('ololo' => 'trololo');

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_gets_associative_array_in_one_line_starting_with_array_and_contains_one_number_value(){
		$string = "\$test = Array('ololo' => 1487);";
		$expectedArr = Array('ololo' => 1487);

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_gets_associative_array_in_one_line_starting_with_array_and_contains_two_string_value(){
		$string = "\$test = Array('ololo' => 'trololo', 'foo' => 'bar');";
		$expectedArr = Array('ololo' => 'trololo', 'foo' => 'bar');

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_gets_associative_array_in_one_line_starting_with_array_and_contains_two_number_value(){
		$string = "\$test = Array('ololo' => 1487, 'foo' => 1489);";
		$expectedArr = Array('ololo' => 1487, 'foo' => 1489);

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_gets_associative_array_in_two_lines_starting_with_array_and_contains_two_string_value(){
		$string = "\$test = Array('ololo' => 'trololo',\r\n
		'foo' => 'bar');";
		$expectedArr = Array('ololo' => 'trololo', 'foo' => 'bar');

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_gets_associative_array_in_four_lines_starting_with_array_and_contains_two_string_value(){
		$string = "\$test = Array(\r\n
		'ololo' => 'trololo',\r\n
		'foo' => 'bar'\r\n
		);";
		$expectedArr = Array('ololo' => 'trololo', 'foo' => 'bar');

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_gets_associative_array_in_one_line_starting_with_array_and_contains_one_string_value_and_empty_subarray(){
		$string = "\$test = Array('ololo' => 'trololo', 'emptyarr' => Array());";
		$expectedArr = Array('ololo' => 'trololo', 'emptyarr' => Array());

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_gets_associative_array_in_one_line_starting_with_array_and_contains_one_string_value_and_similar_subarray(){
		$string = "\$test = Array('ololo' => 'trololo', 'subarr' => Array('foo' => 'bar'));";
		$expectedArr = Array('ololo' => 'trololo', 'subarr' => Array('foo' => 'bar'));

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_gets_associative_array_in_one_line_starting_with_array_and_contains_one_string_value_and_subarray_with_two_strings_value(){
		$string = "\$test = Array('ololo' => 'trololo', 'subarr' => Array('foo' => 'bar', 'baz' => 'bazz'));";
		$expectedArr = Array('ololo' => 'trololo', 'subarr' => Array('foo' => 'bar', 'baz' => 'bazz'));

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_gets_associative_array_in_one_line_starting_with_array_and_contains_one_string_value_and_subarray_with_one_string_value_and_string_value_after_subarray(){
		$string = "\$test = Array('ololo' => 'trololo', 'subarr' => Array('foo' => 'bar'), 'baz' => 'bazz');";
		$expectedArr = Array('ololo' => 'trololo', 'subarr' => Array('foo' => 'bar'), 'baz' => 'bazz');

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');
		//dd($expectedArr);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_gets_associative_array_in_one_line_starting_with_array_and_contains_one_string_value_and_subarray_with_two_string_values_and_string_value_after_subarray(){
		$string = "\$test = Array('ololo' => 'trololo', 'subarr' => Array('foo' => 'bar', 'a' => 'b'), 'baz' => 'bazz');";
		$expectedArr = Array('ololo' => 'trololo', 'subarr' => Array('foo' => 'bar', 'a' => 'b'), 'baz' => 'bazz');

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');
		//dd($expectedArr);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_gets_associative_array_in_one_line_starting_with_array_and_contains_one_string_value_and_subarray_with_string_value_and_subarray_with_string_value(){
		$string = "\$test = Array('ololo' => 'trololo', 'subarr' => Array('foo' => 'bar', 'subsub' => Array('a' => 'b')));";
		$expectedArr = Array('ololo' => 'trololo', 'subarr' => Array('foo' => 'bar', 'subsub' => Array('a' => 'b')));

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');
		//dd($expectedArr);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_parses_old_header_select_description_arr(){
		$string = '$arComponentDescription = array(
	"NAME" => GetMessage("REGIONS_COMPONENT_NAME"),
	"DESCRIPTION" => GetMessage("REGIONS_COMPONENT"),
	"ICON" => "/images/regions.gif",
	"SORT" => 10,
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "v_regions",
		"SORT" => 2200,
		"NAME" => GetMessage("V_REGIONS_COMPONENTS"),
		"CHILD" => array(
			"ID" => "v_regions_select",
			"NAME" => GetMessage("V_REGIONS_SELECT"),
			"SORT" => 10,
		)
	),
);';
		$expectedArr = array(
			"NAME"        => 'GetMessage("REGIONS_COMPONENT_NAME")',
			"DESCRIPTION" => 'GetMessage("REGIONS_COMPONENT")',
			"ICON"        => "/images/regions.gif",
			"SORT"        => 10,
			"CACHE_PATH"  => "Y",
			"PATH"        => array(
				"ID"    => "v_regions",
				"SORT"  => 2200,
				"NAME"  => 'GetMessage("V_REGIONS_COMPONENTS")',
				"CHILD" => array(
					"ID"   => "v_regions_select",
					"NAME" => 'GetMessage("V_REGIONS_SELECT")',
					"SORT" => 10,
				)
			),
		);

		$gottenArr = $this->vArrParse->parseFromText($string, 'arComponentDescription');
		//dd($gottenArr);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_gets_associative_array_in_one_line_starting_with_array_and_contains_two_subarrays_with_string_value(){
		$string = "\$test = Array('ololo' => 'trololo', 'subarr' => Array('foo' => 'bar'), 'subsub' => Array('a' => 'b'));";
		$expectedArr = Array('ololo' => 'trololo', 'subarr' => Array('foo' => 'bar'), 'subsub' => Array('a' => 'b'));

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');
		//dd($expectedArr);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_gets_associative_array_starting_with_array_and_contains_subarray_with_subarray_with_string_value(){
		$string = "\$test = Array('subarr' => Array('subsub' => Array('a' => 'b')));";
		$expectedArr = Array('subarr' => Array('subsub' => Array('a' => 'b')));

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');
		//dd($expectedArr);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_gets_associative_array_starting_with_array_and_contains_empty_array_followed_by_subarray_with_subarray_with_string_value(){
		$string = "\$test = Array('ololo' => Array(), 'subarr' => Array('subsub' => Array('a' => 'b')));";
		$expectedArr = Array('ololo' => Array(), 'subarr' => Array('subsub' => Array('a' => 'b')));

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');
		//dd($expectedArr);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_gets_array_starting_with_array_and_contains_two_subarrays_with_string_value_in_each(){
		$string = "\$test = Array(Array('a' => 'b'), Array('subsub' => 'ololo'));";
		$expectedArr = Array(Array('a' => 'b'), Array('subsub' => 'ololo'));

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');
		//dd($expectedArr);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_gets_non_asociative_array_with_two_string_values(){
		$string = "\$test = Array('a', 'b');";
		$expectedArr = Array('a', 'b');

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');
		//dd($expectedArr);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_gets_non_asociative_array_with_two_empty_arrays(){
		$string = "\$test = Array(Array(), Array());";
		$expectedArr = Array(Array(), Array());

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');
		//dd($expectedArr);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_gets_non_asociative_array_with_ass_array_of_three_els_and_with_ass_arr_of_one_el(){
		// не представляю почему, но в этой ситуации всё падает, если в первом подмассиве 3, 6, 8 элементов
		$string = '$test = array(
	"one" => Array(
		"a" => "b",
		"c"   => "d",
		"e"   => "f"
	),
	"two"      => Array(
		"g"   => "h",
	));';
		$expectedArr = array(
			"one" => Array(
				"a" => "b",
				"c" => "d",
				"e" => "f"
			),
			"two" => Array(
				"g" => "h",
			)
		);

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');
		//dd($gottenArr);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_parses_compact_ass_array_of_one_string_value(){
		// не представляю почему, но в этой ситуации всё падает, если в первом подмассиве 3, 6, 8 элементов
		$string = '$test["ololo"] = "trololo";';
		$expectedArr['ololo'] = 'trololo';

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');
		//dd($gottenArr);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_parses_two_compact_ass_arrays_of_one_string_value_that_are_of_one_name(){
		$string = '$test["ololo"] = "trololo"; $test["foo"] = "bar";';
		$expectedArr['ololo'] = 'trololo';
		$expectedArr['foo'] = 'bar';

		$gottenArr = $this->vArrParse->parseFromText($string, 'test');
		//dd($gottenArr);

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_doesnt_care_about_dollar_character(){
		$string = "\$test = Array('ololo' => 'trololo');";
		$expectedArr = Array('ololo' => 'trololo');

		$gottenArr = $this->vArrParse->parseFromText($string, '$test');

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_returns_empty_arr_if_arr_is_actually_empty(){
		$string = "\$test = Array();";
		$expectedArr = Array();

		$gottenArr = $this->vArrParse->parseFromText($string, '$test');

		$this->assertEquals($expectedArr, $gottenArr);
	}

	/** @test */
	function it_returns_empty_arr_if_there_is_no_arr_with_such_name(){
		$string = "Array();";
		$expectedArr = [];

		$gottenArr = $this->vArrParse->parseFromText($string, '$test');

		$this->assertEquals($expectedArr, $gottenArr);
	}
}

?>