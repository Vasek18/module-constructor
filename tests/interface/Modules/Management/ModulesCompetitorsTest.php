<?php

use App\Models\Modules\Management\ModulesClientsIssue;
use App\Models\Modules\Management\ModulesCompetitor;
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
            return ModulesCompetitor::where('name', $params['name'])->first();
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

    /** @test */
    function userCannotSeeCompetitorsOfStrangersModule(){
        $this->createCompetitor([
            'name'    => 'Ololo module',
            'link'    => 'http://heh.ru',
            'price'   => 100,
            'sort'    => 200,
            'comment' => 'Lorem ipsum',
        ]);

        // заходим на страницу под другим пользователем
        $this->signIn(factory(User::class)->create());
        $this->visit(action('Modules\Management\ModulesCompetitorsController@index', $this->module->id));

        $this->dontSee('Ololo module');
        $this->seePageIs('/personal/');
    }

    /** @test */
    function userCannotDeleteCompetitorOfStrangersModule(){
        $competitor = $this->createCompetitor([
            'name'    => 'Ololo module',
            'link'    => 'http://heh.ru',
            'price'   => 100,
            'sort'    => 200,
            'comment' => 'Lorem ipsum',
        ]);

        $this->assertEquals(1, ModulesCompetitor::where('name', 'Ololo module')->count());

        // удаляем под другим пользователем
        $this->signIn(factory(User::class)->create());
        $module2 = $this->fillNewBitrixForm();
        $this->get(action('Modules\Management\ModulesCompetitorsController@delete', [
            $module2->id,
            $competitor->id
        ]));

        $this->assertEquals(1, ModulesCompetitor::where('name', 'Ololo module')->count());
    }
}
