<?php

use App\Models\Modules\Management\ModulesClientsIssue;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group modules_management */
class ModulesCompetitorsTest extends BitrixTestCase{

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

    function createCompetitor($params){
        $this->visit(action('Modules\Management\ModulesCompetitorsController@create', $this->module->id));

        // создадим сразу два
        $this->submitForm(
            'save',
            $params
        );

        if ($params['name']){
            return ModulesClientsIssue::where('name', $params['name'])->first();
        }
    }

    /** @test */
    function userCanCreateCompetitor(){
        $this->createCompetitor([
            'name'    => 'Ололошный модуль',
            'link'    => 'http://heh.ru',
            'price'   => 100,
            'sort'    => 200,
            'comment' => 'Lorem ipsum',
        ]);

        $this->seePageIs(action('Modules\Management\ModulesCompetitorsController@index', $this->module->id));
        $this->see('Ололошный модуль');
    }
}
