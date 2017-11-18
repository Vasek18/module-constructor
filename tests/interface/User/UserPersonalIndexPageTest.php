<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group user */
class UserPersonalIndexPageTest extends \TestCase{

    use DatabaseTransactions;

    /** @test */
    function userCanSetModulesSorting(){
        $this->signIn();

        // создаём модуль, указываем сортировку
        $module1 = $this->fillNewBitrixForm(['MODULE_CODE' => 'test']);
        $this->visit(action('PersonalController@index'));
        $this->submitForm(
            'setSort'.$module1->id,
            [
                'sort' => 300
            ]
        );
        // создаём второй модуль, указываем сортировку
        $module2 = $this->fillNewBitrixForm(['MODULE_CODE' => 'ololo']);
        $this->visit(action('PersonalController@index'));
        $this->submitForm(
            'setSort'.$module2->id,
            [
                'sort' => 200
            ]
        );

        // проверяем заполнение инпутов
        $this->visit(action('PersonalController@index'));
        $this->seeInField('sort'.$module1->id, 300);
        $this->seeInField('sort'.$module2->id, 200);

        // удостоверяемся, что сортировка сработала
        $pageContent = $this->response->getContent();
        $this->assertTrue(strpos($pageContent, 'sort'.$module1->id) > strpos($pageContent, 'sort'.$module2->id));

        // не засоряем папку
        $module1->deleteFolder();
        $module2->deleteFolder();
    }
}