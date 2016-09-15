<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Helpers\vArrParse;
use App\Helpers\vFuncParse;
use App\Models\Modules\Bitrix\BitrixMailEventsVar;

class BitrixEventHandlersFilesTest extends BitrixTestCase{

	use DatabaseTransactions;

	protected $path = '/events_handlers';

	function setUp(){
		parent::setUp();

		$this->signIn();
		$this->module = $this->fillNewBitrixForm();
	}

	function tearDown(){
		parent::tearDown();

		$this->module->deleteFolder();
	}

	/** @test */
	function it_saves_event_handler(){
		$this->createEventHandlerOnForm($this->module, 0, [
			'from_module' => 'main',
			'event'       => 'OnProlog',
			'class'       => 'MyClass',
			'method'      => 'Handler',
			'php_code'    => '<?="ololo";?>',
		]);
	}
}

?>