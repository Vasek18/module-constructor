<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group bitrix_interface */
class BitrixSiteTemplatesInterfaceTest extends BitrixTestCase{

    use DatabaseTransactions;

    function setUp(){
        parent::setUp();

        $this->signIn();
        $this->module = $this->fillNewBitrixSiteForm();
    }

    function tearDown(){
        parent::tearDown();

        if ($this->module){
            $this->module->deleteFolder();
        }
    }

    /** @test */
    function it_returns_an_error_when_archive_is_not_a_single_folder_at_creation(){
        $template = $this->createSiteTemplateOnForm($this->module, ['file' => public_path().DIRECTORY_SEPARATOR.'for_tests'.DIRECTORY_SEPARATOR.'empty.zip']);

        $this->seeText('Архив не соответствует требованиям');
    }
}
