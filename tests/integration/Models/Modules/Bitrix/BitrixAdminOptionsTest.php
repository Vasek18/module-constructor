<?php

use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixAdminOptions;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BitrixAdminOptionsTest extends TestCase{

	use DatabaseTransactions;

	/** @test */
	function store_method_works(){
		$this->signIn();

		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);

		$option = BitrixAdminOptions::store($module, [
				"sort"           => 10,
				"name"           => 'Ололо',
				"code"           => 'ololo',
				"type_id"        => 0,
				"height"         => '10',
				"width"          => '20',
				"spec_vals"      => '',
				"spec_vals_args" => ''
			]
		);

		$this->seeInDatabase('bitrix_modules_options', [
			"module_id" => $module->id,
			"sort"      => 10,
			"name"      => 'Ололо',
			"code"      => 'ololo',
			"type_id"   => 0,
			"height"    => '10',
			"width"     => '20'
		]);

	}

	// todo /** @test */
	//function it_create_handler_without_type_id_field_with_string_type_id(){
	//}
	//
	// todo /** @test */
	//function it_doesnt_create_handler_with_nonexistent_type_id(){
	//}
	//
	// todo /** @test */
	//function it_doesnt_create_handler_without_code_field(){
	//}
	//
	// todo /** @test */
	//function it_doesnt_create_handler_without_name_field(){
	//}

	/** @test */
	function hackers_cant_use_other_user_module_id(){
		$this->signIn();

		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);

		$module2 = factory(App\Models\Modules\Bitrix\Bitrix::class)->create();

		$option = BitrixAdminOptions::store($module2, [
				"sort"           => 10,
				"name"           => 'Ололо',
				"code"           => 'ololo',
				"type_id"        => 0,
				"height"         => '10',
				"width"          => '20',
				"spec_vals"      => '',
				"spec_vals_args" => ''
			]
		);

		$this->seeInDatabase('bitrix_modules_options', [
			"module_id" => $module2->id,
			"sort"      => 10,
			"name"      => 'Ололо',
			"code"      => 'ololo',
			"type_id"   => 0,
			"height"    => '10',
			"width"     => '20'
		]);
	}

	// todo /** @test */
	//function it_creates_file_for_options(){
	//}
	//
	// todo /** @test */
	//function it_writes_option_in_file(){
	//}
	//
	// todo /** @test */
	//function it_saves_select_vals_in_bd(){
	//}
	//
	// todo /** @test */
	//function it_writes_select_vals_in_file(){
	//}
	//
	// todo /** @test */
	//function it_writes_string_type_options_in_right_format_in_file(){
	//}
	//
	// todo /** @test */
	//function it_writes_textarea_type_options_in_right_format_in_file(){
	//}
	//
	// todo /** @test */
	//function it_writes_select_type_options_in_right_format_in_file(){
	//}
	//
	// todo /** @test */
	//function it_writes_multiple_select_type_options_in_right_format_in_file(){
	//}
	//
	// todo /** @test */
	//function it_writes_checkbox_type_options_in_right_format_in_file(){
	//}
}