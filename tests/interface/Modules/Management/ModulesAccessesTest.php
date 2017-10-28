<?php

use App\Models\Modules\Management\ModulesAccess;
use App\Models\Modules\Management\ModulesClientsIssue;
use App\Models\Modules\Management\ModulesCompetitor;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group modules_management */
class ModulesAccessesTest extends BitrixTestCase{

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

    function grantAccess($userEmail, $permissionCodes, $moduleID, $fieldsCount = 0){
        $this->visit(action('Modules\Management\ModulesAccessesController@index', $moduleID));

        $this->type($userEmail, 'email['.$fieldsCount.']');
        foreach ($permissionCodes as $permissionCode){
            $this->check('permission['.$fieldsCount.']['.$permissionCode.']');
        }

        // создадим сразу два
        $this->press('save');
    }

    /** @test */
    function userCanSeeOnlyHisModules(){
        // заходим под другим пользователем
        $this->signIn(factory(User::class)->create());
        $module2 = $this->fillNewBitrixForm();

        $this->visit(action('PersonalController@index'));
        $this->dontSee($this->module->module_full_id);
        $this->see($module2->module_full_id);
    }

    /** @test */
    function userCanGrantAccess(){
        $anotherUserEmail = 'ololo@ololo.ru';

        // даём доступ
        $this->grantAccess($anotherUserEmail, ['D'], $this->module->id);

        // заходим под тем пользователем
        $this->signIn(factory(User::class)->create(['email' => $anotherUserEmail]));
        $this->visit(action('PersonalController@index'));

        // видим, что появился модуль с нужными кнопками
        $this->see($this->module->module_full_id);
        // видим ссылку на разработку
        $this->see('http://constructor.local/my-bitrix/'.$this->module->id);
    }
}
