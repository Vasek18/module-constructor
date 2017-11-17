<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Modules\Bitrix\BitrixAdminMenuItems;

/** @group bitrix_interface */
class BitrixAdminMenuInterfaceTest extends BitrixTestCase{

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

    /** @test */
    function author_can_get_to_this_page(){
        $this->visit('/my-bitrix/'.$this->module->id.'/admin_menu');

        $this->seePageIs('/my-bitrix/'.$this->module->id.'/admin_menu');
    }

    /** @test */
    function this_is_definitely_page_about_iblock(){
        $this->visit('/my-bitrix/'.$this->module->id.'/admin_menu');

        $this->see('Страницы административного меню');
    }

    /** @test */
    function unauthorized_cannot_get_to_this_page(){
        $this->logOut();

        $this->visit('/my-bitrix/'.$this->module->id.'/admin_menu');

        $this->seePageIs(route('login'));
    }

    /** @test */
    function not_author_cannot_get_to_this_page_of_anothers_module(){
        $this->signIn(factory(App\Models\User::class)->create());

        $this->visit('/my-bitrix/'.$this->module->id.'/admin_menu');

        $this->seePageIs('/personal');
    }

    /** @test */
    function it_returns_page_data_after_save(){
        $amp = $this->createAdminPageOnForm(
            $this->module,
            [
                'name'        => 'Ololo',
                'code'        => 'trololo',
                "sort"        => "334",
                "text"        => "item",
                "parent_menu" => "global_menu_settings",
                "php_code"    => '<a href="test">test</a>',
                "lang_code"   => '<? $MESS["TEST"] = "test"; ?>'
            ]
        );

        $this->seeInField('name', 'Ololo');
        $this->seeInField('code', 'trololo');
        $this->seeInField("sort", "334");
        $this->seeInField("text", "item");
        $this->seeIsSelected("parent_menu", "global_menu_settings");
        $this->seeInField("php_code", '<a href="test">test</a>');
        $this->seeInField("lang_code", '<? $MESS["TEST"] = "test"; ?>');

        $this->seePageIs('/my-bitrix/'.$this->module->id.'/admin_menu/'.$amp->id);
    }

    /** @test */
    function it_returns_an_error_when_there_is_no_code(){
        $amp = $this->createAdminPageOnForm(
            $this->module,
            [
                'name'        => 'Ololo',
                'code'        => '',
                "parent_menu" => "global_menu_settings",
            ]
        );

        $this->see('Поле "Код" обязательно');
        $this->seePageIs('/my-bitrix/'.$this->module->id.'/admin_menu/create');
    }

    /** @test */
    function it_returns_an_error_when_there_is_no_name(){
        $amp = $this->createAdminPageOnForm($this->module, [
            'name' => '',
            'code' => 'trololo'
        ]);

        $this->deleteFolder($this->standartModuleCode);

        $this->see('Поле "Название" обязательно');
        $this->seePageIs('/my-bitrix/'.$this->module->id.'/admin_menu/create');
    }

    /** @test */
    function it_can_remove_admin_menu_page(){
        $amp = $this->createAdminPageOnForm($this->module, ['name' => 'Ololoamp']);
        $this->removeAdminPage($this->module, $amp);

        $this->visit(action('Modules\Bitrix\BitrixAdminMenuController@index', [$this->module]))->dontSee('Ololoamp');
    }

        /** @test */
        function stranger_cannot_remove_admin_menu_page(){
            $amp    = $this->createAdminPageOnForm($this->module, ['name' => 'Ololoamp']);

            $this->signIn(factory(App\Models\User::class)->create());
            $module2 = $this->fillNewBitrixForm();

            $this->get(action('Modules\Bitrix\BitrixAdminMenuController@destroy', [$module2, $amp]));

            $this->assertEquals(1, BitrixAdminMenuItems::where('name', 'Ololoamp')->count());
        }
}

?>