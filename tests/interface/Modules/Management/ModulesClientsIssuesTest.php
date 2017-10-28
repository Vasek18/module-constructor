<?php

use App\Models\Modules\Management\ModulesClientsIssue;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group modules_management */
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

    /** @test */
    //    function userCanChangeIssueDescription(){
    //        $issue = $this->createIssue('Test issue', 'Popular');
    //
    //        $this->seeInField('description_'.$issue->id, 'Popular');
    //
    //        $this->submitForm('change_description_'.$issue->id, [
    //            'description' => 'Ololo'
    //        ]);
    //
    //        $this->seeInField('description_'.$issue->id, 'Ololo');
    //    }

    /** @test */
    function userCanMarkIssueAsSolved(){
        $issue = $this->createIssue('Test issue', 'Popular');

        $this->dontSee('not_solved_'.$issue->id);

        $this->press('solved_'.$issue->id);

        $this->see('not_solved_'.$issue->id);
    }

    /** @test */
    function userCanMarkSolvedIssueAsNotSolved(){
        $issue = $this->createIssue('Test issue', 'Popular');

        $this->press('solved_'.$issue->id);

        $this->press('not_solved_'.$issue->id);

        $this->see('solved_'.$issue->id);
        $this->dontSee('not_solved_'.$issue->id);
    }

    /** @test */
    function userCanDeleteSolvedIssue(){
        $issue = $this->createIssue('Test issue', 'Popular');

        $this->press('solved_'.$issue->id);

        $this->press('delete_'.$issue->id);

        $this->dontSee('Test issue');
    }

    /** @test */
    function userCannotSeeIssuesOfStrangersModule(){
        $this->createIssue('Test issue', 'Popular');

        // заходим на страницу под другим пользователем
        $this->signIn(factory(User::class)->create());
        $this->get(action('Modules\Management\ModulesClientsIssueController@index', $this->module->id));
        $this->assertResponseStatus(404);
    }

    /** @test */
    function userCannotDeleteIssueOfStrangersModule(){
        $issue = $this->createIssue('Test issue', 'Popular');

        $this->assertEquals(1, ModulesClientsIssue::where('name', 'Test issue')->count());

        // удаляем под другим пользователем
        $this->signIn(factory(User::class)->create());
        $module2 = $this->fillNewBitrixForm();
        $this->post(action('Modules\Management\ModulesClientsIssueController@destroy', [
            $module2->id,
            $issue->id
        ]));

        $this->assertEquals(1, ModulesClientsIssue::where('name', 'Test issue')->count());
    }
}
