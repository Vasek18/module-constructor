<?php

use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Management\ModulesAccess;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;

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

    function cancelAccess($userEmail, $permissionCode, $moduleID){
        $this->visit(action('Modules\Management\ModulesAccessesController@index', $moduleID));

        $access = ModulesAccess::where('user_email', $userEmail)->where('module_id', $moduleID)->where('permission_code', $permissionCode)->first();

        $this->click('cancel_access_'.$access->id);
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
    function userCanGrantAccessToDevelopment(){
        $anotherUserEmail = 'ololo@ololo.ru';

        // даём доступ
        $this->grantAccess($anotherUserEmail, ['D'], $this->module->id);

        // заходим под тем пользователем
        $this->signIn(factory(User::class)->create(['email' => $anotherUserEmail]));
        $this->visit(action('PersonalController@index'));

        // видим, что у пользователя появился модуль с нужными кнопками
        $this->see($this->module->module_full_id);
        // видим ссылку на разработку
        $this->see(action('Modules\Bitrix\BitrixController@show', [$this->module->id]));
        // не видим ссылку на менеджмент
        $this->dontSee(action('Modules\Management\ModulesManagementController@index', [$this->module->id]));

        // можем перейти на ссылку для разработчиков
        $this->get(action('Modules\Bitrix\BitrixController@show', [$this->module->id]));
        $this->assertResponseStatus(200);

        // не можем перейти на ссылку для менеджеров
        $this->get(action('Modules\Management\ModulesManagementController@index', [$this->module->id]));
        $this->assertResponseStatus(404);
    }

    /** @test */
    function userCanGrantAccessToManagement(){
        $anotherUserEmail = 'ololo@ololo.ru';

        // даём доступ
        $this->grantAccess($anotherUserEmail, ['M'], $this->module->id);

        // заходим под тем пользователем
        $this->signIn(factory(User::class)->create(['email' => $anotherUserEmail]));
        $this->visit(action('PersonalController@index'));

        // видим, что у пользователя появился модуль с нужными кнопками
        $this->see($this->module->module_full_id);
        // не видим ссылку на разработку
        $this->dontSee(action('Modules\Bitrix\BitrixController@show', [$this->module->id]));
        // видим ссылку на менеджмент
        $this->see(action('Modules\Management\ModulesManagementController@index', [$this->module->id]));

        // не можем перейти на ссылку для разработчиков
        $this->get(action('Modules\Bitrix\BitrixController@show', [$this->module->id]));
        $this->assertResponseStatus(302); // todo это временно, потом будет 404

        // можем перейти на ссылку для менеджеров
        $this->get(action('Modules\Management\ModulesManagementController@index', [$this->module->id]));
        $this->assertResponseStatus(200);
    }

    /** @test */
    function onlyOwnerCanDeleteModule(){
        $anotherUserEmail = 'ololo@ololo.ru';

        // даём доступ
        $this->grantAccess($anotherUserEmail, [
            'D',
            'M'
        ], $this->module->id);

        // заходим под тем пользователем
        $this->signIn(factory(User::class)->create(['email' => $anotherUserEmail]));
        $this->visit(action('PersonalController@index'));

        // видим, что у пользователя появился модуль с нужными кнопками
        $this->see($this->module->module_full_id);
        // не видим ссылку удаление
        $this->dontSee('modal_delete_'.$this->module->id);
        $this->dontSee('Удалить');

        // пытаемся удалить по прямой ссылке
        $this->delete(action('Modules\Bitrix\BitrixController@destroy', [$this->module->id]));
        // видим что модуль не удалился
        $this->assertEquals(1, Bitrix::where('id', $this->module->id)->count());
    }

    /** @test */
    function userCanCancelAccess(){
        // запоминаем пользователя
        $firstUser = $this->user;

        $anotherUserEmail = 'ololo@ololo.ru';

        // даём доступ
        $this->grantAccess($anotherUserEmail, ['D'], $this->module->id);

        // заходим под тем пользователем
        $this->signIn(factory(User::class)->create(['email' => $anotherUserEmail]));
        $this->visit(action('PersonalController@index'));
        // запоминаем этого пользователя
        $secondUser = $this->user;

        // видим, что у пользователя появился модуль с нужными кнопками
        $this->see($this->module->module_full_id);

        // заходим обратно под первым пользователем
        $this->signIn($firstUser);
        // отменяем доступ
        $this->cancelAccess($anotherUserEmail, 'D', $this->module->id);

        // снова заходим под тем пользователем
        $this->signIn($secondUser);
        $this->visit(action('PersonalController@index'));

        // видим, что у пользователя удалился модуль с нужными кнопками
        $this->dontSee($this->module->module_full_id);
    }

    //    /** @test */
    //    function onlyOwnersAndDevelopersCanDownloadModule(){
    //        $developerEmail = 'ololo@ololo.ru';
    //        $managerEmail   = 'trololo@trololo.ru';
    //
    //        // даём доступы
    //        $this->grantAccess($developerEmail, ['D'], $this->module->id);
    //        $this->grantAccess($managerEmail, ['M'], $this->module->id);
    //
    //        // заходим под тем разработчиком
    //        $this->signIn(factory(User::class)->create(['email' => $developerEmail]));
    //        // пробуем скачать
    //        $this->post(action(action('Modules\Bitrix\BitrixController@download_zip', $this->module->id)));
    //        // todo успех
    //
    //        // заходим под менеджером
    //        $this->signIn(factory(User::class)->create(['email' => $managerEmail]));
    //        // пробуем скачать
    //        $this->post(action(action('Modules\Bitrix\BitrixController@download_zip', $this->module->id)));
    //        // todo не успех
    //    }

    /** @test */
    public function onlyOwnerCanManageAccesses(){
        $anotherUserEmail = 'ololo@ololo.ru';

        // даём доступ
        $this->grantAccess($anotherUserEmail, [
            'D',
            'M'
        ], $this->module->id);

        // заходим под тем пользователем
        $this->signIn(factory(User::class)->create(['email' => $anotherUserEmail]));

        // пытаемся зайти на страницу по прямой ссылке
        $this->get(action('Modules\Management\ModulesAccessesController@index', [$this->module->id]));
        $this->assertResponseStatus(404);
    }

//    /** @test */ // todo
//    public function afterCreatingAccessEmailIsSent(){
//        Mail::fake();
//
//        $anotherUserEmail = 'ololo@ololo.ru';
//
////         даём доступ
//        $this->grantAccess($anotherUserEmail, [
//            'D',
//        ], $this->module->id);
//
//
//        Mail::shouldReceive('send')->once();
//    }
}
