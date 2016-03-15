<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BitrixTest extends TestCase{

	use DatabaseTransactions;

	/** @test */
	function it_can_upgrade_version_of_module(){
		$bitrix = factory(App\Models\Modules\Bitrix\Bitrix::class)->create();

		Bitrix::upgradeVersion($bitrix->id, "0.0.2");

		$module = Bitrix::find($bitrix->id);

		$this->assertEquals("0.0.2", $module->VERSION);


	}
}

?>