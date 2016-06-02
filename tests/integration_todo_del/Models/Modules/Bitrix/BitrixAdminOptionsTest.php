<?php

use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixAdminOptions;
use App\Models\Modules\Bitrix\BitrixAdminOptionsVals;
//use Illuminate\Foundation\Testing\DatabaseTransactions;
//
//class BitrixAdminOptionsTest extends TestCase{
//
//	use DatabaseTransactions;
//
//	protected static function stringType(){
//		return 1;
//	}
//
//	protected static function textareaType(){
//		return 2;
//	}
//
//	protected static function selectType(){
//		return 3;
//	}
//
//	protected static function multiselectType(){
//		return 4;
//	}
//
//	protected static function checkboxType(){
//		return 5;
//	}
//
//	/** @test */
//	function store_method_works(){
//		$this->signIn();
//
//		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);
//
//		$option = BitrixAdminOptions::store($module, [
//				"sort"           => 10,
//				"name"           => 'Ололо',
//				"code"           => 'ololo',
//				"type_id"        => $this->stringType(),
//				"height"         => '10',
//				"width"          => '20',
//				"spec_vals"      => '',
//				"spec_vals_args" => ''
//			]
//		);
//
//		$this->seeInDatabase('bitrix_modules_options', [
//			"module_id" => $module->id,
//			"sort"      => 10,
//			"name"      => 'Ололо',
//			"code"      => 'ololo',
//			"type_id"   => $this->stringType(),
//			"height"    => '10',
//			"width"     => '20'
//		]);
//	}
//
//	/** @test */
//	function it_create_handler_without_type_id_field_with_string_type_id(){
//		$this->signIn();
//
//		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);
//
//		$option = BitrixAdminOptions::store($module, [
//				"sort"           => 10,
//				"name"           => 'Ололо',
//				"code"           => 'ololo',
//				"spec_vals"      => '',
//				"spec_vals_args" => ''
//			]
//		);
//
//		$this->seeInDatabase('bitrix_modules_options', [
//			"module_id" => $module->id,
//			"sort"      => 10,
//			"name"      => 'Ололо',
//			"code"      => 'ololo',
//			"type_id"   => $this->stringType()
//		]);
//	}
//
//	/** @test */
//	function it_create_handler_with_nonexistent_type_id_with_string_type_id(){
//		$this->signIn();
//
//		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);
//
//		$option = BitrixAdminOptions::store($module, [
//				"sort"           => 10,
//				"name"           => 'Ололо',
//				"type_id"        => 1487,
//				"code"           => 'ololo',
//				"spec_vals"      => '',
//				"spec_vals_args" => ''
//			]
//		);
//
//		$this->seeInDatabase('bitrix_modules_options', [
//			"module_id" => $module->id,
//			"sort"      => 10,
//			"name"      => 'Ололо',
//			"code"      => 'ololo',
//			"type_id"   => $this->stringType()
//		]);
//	}
//
//	/** @test */
//	function it_doesnt_create_handler_without_code_field(){
//		$this->signIn();
//
//		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);
//
//		$option = BitrixAdminOptions::store($module, [
//				"sort"           => 10,
//				"name"           => 'Ололо',
//				"type_id"        => 1,
//				"height"         => '10',
//				"width"          => '20',
//				"spec_vals"      => '',
//				"spec_vals_args" => ''
//			]
//		);
//
//		$this->dontSeeInDatabase('bitrix_modules_options', [
//			"module_id" => $module->id,
//			"sort"      => 10,
//			"name"      => 'Ололо',
//			"type_id"   => $this->stringType(),
//			"height"    => '10',
//			"width"     => '20'
//		]);
//	}
//
//	/** @test */
//	function it_doesnt_create_handler_without_name_field(){
//		$this->signIn();
//
//		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);
//
//		$option = BitrixAdminOptions::store($module, [
//				"sort"           => 10,
//				"code"           => 'ololo',
//				"type_id"        => $this->stringType(),
//				"height"         => '10',
//				"width"          => '20',
//				"spec_vals"      => '',
//				"spec_vals_args" => ''
//			]
//		);
//
//		$this->dontSeeInDatabase('bitrix_modules_options', [
//			"module_id" => $module->id,
//			"sort"      => 10,
//			"code"      => 'ololo',
//			"type_id"   => $this->stringType(),
//			"height"    => '10',
//			"width"     => '20'
//		]);
//	}
//
//	/** @test */
//	function hackers_cant_use_other_user_module_id(){
//		$this->signIn();
//
//		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);
//
//		$module2 = factory(App\Models\Modules\Bitrix\Bitrix::class)->create();
//
//		$option = BitrixAdminOptions::store($module2, [
//				"sort"           => 10,
//				"name"           => 'Ололо',
//				"code"           => 'ololo',
//				"type_id"        => $this->stringType(),
//				"height"         => '10',
//				"width"          => '20',
//				"spec_vals"      => '',
//				"spec_vals_args" => ''
//			]
//		);
//
//		$this->dontSeeInDatabase('bitrix_modules_options', [
//			"module_id" => $module2->id,
//			"sort"      => 10,
//			"name"      => 'Ололо',
//			"code"      => 'ololo',
//			"type_id"   => $this->stringType(),
//			"height"    => '10',
//			"width"     => '20'
//		]);
//	}
//
//	/** @test */
//	function it_creates_file_for_options(){
//		$this->signIn();
//
//		$module = $this->useBitrixStoreMethod();
//
//		$option = BitrixAdminOptions::store($module, [
//				"sort"           => 10,
//				"name"           => 'Ололо',
//				"code"           => 'ololo',
//				"type_id"        => $this->stringType(),
//				"height"         => '10',
//				"width"          => '20',
//				"spec_vals"      => '',
//				"spec_vals_args" => ''
//			]
//		);
//
//		BitrixAdminOptions::saveOptionFile($module->id);
//
//		$dirName = Bitrix::getFolder($module);
//
//		$this->assertFileExists($dirName.'\\options.php');
//
//		Bitrix::deleteFolder($module);
//	}
//
//	/** @test */
//	function it_writes_string_type_options_in_right_format_in_file(){
//		$this->signIn();
//
//		$module = $this->useBitrixStoreMethod();
//
//		$option = BitrixAdminOptions::store($module, [
//				"sort"           => 10,
//				"name"           => 'Ололо',
//				"code"           => 'ololo',
//				"type_id"        => $this->stringType(),
//				"spec_vals"      => '',
//				"spec_vals_args" => ''
//			]
//		);
//
//		BitrixAdminOptions::saveOptionFile($module->id);
//
//		$dirName = Bitrix::getFolder($module);
//
//		$content = file_get_contents($dirName.'/options.php');
//
//		//dd($content);
//
//		$optionCode = "array('ololo', Loc::getMessage('".$module->lang_key."_OLOLO_TITLE'), '', array('text', 20)),)"; // todo почему в тесте 20, а в продакшене 0?
//
//		$this->assertNotFalse(strpos($content, $optionCode));
//
//		Bitrix::deleteFolder($module);
//	}
//
//	/** @test */
//	function it_writes_textarea_type_options_in_right_format_in_file(){
//		$this->signIn();
//
//		$module = $this->useBitrixStoreMethod();
//
//		$option = BitrixAdminOptions::store($module, [
//				"sort"    => 10,
//				"name"    => 'Ололо',
//				"code"    => 'ololo',
//				"type_id" => $this->textareaType(),
//				"height"  => 3,
//				"width"   => 20
//			]
//		);
//
//		BitrixAdminOptions::saveOptionFile($module->id);
//
//		$dirName = Bitrix::getFolder($module);
//
//		$content = file_get_contents($dirName.'/options.php');
//
//		$optionCode = "array('ololo', Loc::getMessage('".$module->lang_key."_OLOLO_TITLE'), '', array('textarea', 3, 20))";
//
//		$this->assertNotFalse(strpos($content, $optionCode));
//
//		Bitrix::deleteFolder($module);
//	}
//
//	/** @test */
//	function it_writes_select_type_option_with_vals_in_right_format_in_file(){
//		$this->signIn();
//
//		$module = $this->useBitrixStoreMethod();
//
//		$option = BitrixAdminOptions::store($module, [
//				"sort"           => 10,
//				"name"           => 'Ололо',
//				"code"           => 'ololo',
//				"type_id"        => $this->selectType(),
//				"spec_vals"      => '',
//				"spec_vals_args" => ''
//			]
//		);
//
//		$val = new BitrixAdminOptionsVals;
//		$val->option_id = $option->id;
//		$val->key = "a";
//		$val->value = "b";
//		$val->save();
//
//		$val = new BitrixAdminOptionsVals;
//		$val->option_id = $option->id;
//		$val->key = "c";
//		$val->value = "d";
//		$val->save();
//
//		BitrixAdminOptions::saveOptionFile($module->id);
//
//		$dirName = Bitrix::getFolder($module);
//
//		$content = file_get_contents($dirName.'/options.php');
//
//		$optionCode = "array('ololo', Loc::getMessage('".$module->lang_key."_OLOLO_TITLE'), '', array('selectbox', Array('a' => 'b', 'c' => 'd', )))";
//
//		$this->assertNotFalse(strpos($content, $optionCode));
//
//		Bitrix::deleteFolder($module);
//	}
//
//	/** @test */
//	function it_writes_select_type_option_without_vals_in_right_format_in_file(){
//		$this->signIn();
//
//		$module = $this->useBitrixStoreMethod();
//
//		$option = BitrixAdminOptions::store($module, [
//				"sort"           => 10,
//				"name"           => 'Ололо',
//				"code"           => 'ololo',
//				"type_id"        => $this->selectType(),
//				"spec_vals"      => '',
//				"spec_vals_args" => ''
//			]
//		);
//
//		BitrixAdminOptions::saveOptionFile($module->id);
//
//		$dirName = Bitrix::getFolder($module);
//
//		$content = file_get_contents($dirName.'/options.php');
//
//		$optionCode = "array('ololo', Loc::getMessage('".$module->lang_key."_OLOLO_TITLE'), '', array('selectbox', Array()))";
//
//		$this->assertNotFalse(strpos($content, $optionCode));
//
//		Bitrix::deleteFolder($module);
//	}
//
//	/** @test */
//	function it_writes_multiple_select_type_options_in_right_format_in_file(){
//		$this->signIn();
//
//		$module = $this->useBitrixStoreMethod();
//
//		$option = BitrixAdminOptions::store($module, [
//				"sort"           => 10,
//				"name"           => 'Ололо',
//				"code"           => 'ololo',
//				"type_id"        => $this->multiselectType(),
//				"spec_vals"      => '',
//				"spec_vals_args" => ''
//			]
//		);
//
//		$val = new BitrixAdminOptionsVals;
//		$val->option_id = $option->id;
//		$val->key = "a";
//		$val->value = "b";
//		$val->save();
//
//		$val = new BitrixAdminOptionsVals;
//		$val->option_id = $option->id;
//		$val->key = "c";
//		$val->value = "d";
//		$val->save();
//
//		BitrixAdminOptions::saveOptionFile($module->id);
//
//		$dirName = Bitrix::getFolder($module);
//
//		$content = file_get_contents($dirName.'/options.php');
//
//		$optionCode = "array('ololo', Loc::getMessage('".$module->lang_key."_OLOLO_TITLE'), '', array('multiselectbox', Array('a' => 'b', 'c' => 'd', )))";
//
//		$this->assertNotFalse(strpos($content, $optionCode));
//
//		Bitrix::deleteFolder($module);
//	}
//
//	/** @test */
//	function it_writes_checkbox_type_options_in_right_format_in_file(){
//		$this->signIn();
//
//		$module = $this->useBitrixStoreMethod();
//
//		$option = BitrixAdminOptions::store($module, [
//				"sort"    => 10,
//				"name"    => 'Ололо',
//				"code"    => 'ololo',
//				"type_id" => $this->checkboxType(),
//				"spec_vals_args"  => 'Y'
//			]
//		);
//
//		BitrixAdminOptions::saveOptionFile($module->id);
//
//		$dirName = Bitrix::getFolder($module);
//
//		$content = file_get_contents($dirName.'/options.php');
//
//		$optionCode = "array('ololo', Loc::getMessage('".$module->lang_key."_OLOLO_TITLE'), '', array('checkbox', \"Y\"))";
//
//		$this->assertNotFalse(strpos($content, $optionCode));
//
//		Bitrix::deleteFolder($module);
//	}
//}