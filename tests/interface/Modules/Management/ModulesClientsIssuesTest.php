<?php

use App\Models\Modules\Management\ModulesClientsIssue;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group bitrix_interface */
class ModulesClientsIssuesTest extends BitrixTestCase{

	use DatabaseTransactions;

	function setUp(){
		parent::setUp();

		$this->signIn();
		$this->module = $this->fillNewBitrixForm();
	}

	function tearDown(){
		parent::tearDown();

		if ($this->module){
			$this->module->deleteFolder();
		}
	}

	function createIssue($name, $description = ''){
		$this->visit(action('Modules\Management\ModulesClientsIssueController@index', $this->module->id));

		// создадим сразу два
		$this->submitForm(
			'create_issue',
			[
				'name'        => $name,
				'description' => $description,
			]
		);

		return ModulesClientsIssue::where('name', $name)->where('description', $description)->first();
	}

	/** @test */
	function userCanCreateIssue(){
		$this->createIssue('Test issue', 'Popular');
		$this->createIssue('Ololo issue');

		$this->see('Test issue');
		$this->see('Ololo issue');
	}

	/** @test */
	function userCanChangeIssueCount(){
		$issue = $this->createIssue('Test issue', 'Popular');

		$this->seeInField('appeals_count_'.$issue->id, 1); // сначала 1

		$this->press('increase_'.$issue->id);
		$this->seeInField('appeals_count_'.$issue->id, 2); // увеличиваем на 1 = 2


		$this->press('decrease_'.$issue->id);
		$this->seeInField('appeals_count_'.$issue->id, 1); // уменьшаем на 1 = 1
	}
}
