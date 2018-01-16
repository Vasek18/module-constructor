<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group bitrix_files */
class BitrixSiteTemplatesFormFilesTest extends BitrixTestCase{

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
    public function user_can_create_template(){
        $template = $this->createSiteTemplateOnForm($this->module);

        $this->assertEquals('main', $template->code);
        $this->assertEquals('Ololo', $template->name);
        $this->assertEquals('Trololo', $template->description);
        $this->assertEquals('334', $template->sort);
    }

    /** @test */
    public function it_rewrites_only_description_file_at_creation(){
        $template = $this->createSiteTemplateOnForm($this->module);

        $this->assertNotFalse(strpos(file_get_contents($template->getFolder(true).'/header.php'), 'ololo'));
        $this->assertNotFalse(strpos(file_get_contents($template->getFolder(true).'/description.php'), '334'));
    }

    /** @test */
    function it_creates_all_missing_required_files_at_creation(){
        $template = $this->createSiteTemplateOnForm($this->module, ['file' => public_path().DIRECTORY_SEPARATOR.'for_tests'.DIRECTORY_SEPARATOR.'test_site_template_wo_description_file.zip']);

        $this->assertFileExists($template->getFolder(true).'/description.php');
    }

    /** @test */
    function it_parses_themes_at_creation(){
        $template = $this->createSiteTemplateOnForm($this->module);

        $this->assertEquals('main', $template->themes()->first()->code);
    }

    /** @test */
    function it_deletes_folder_at_deletion(){
        $template = $this->createSiteTemplateOnForm($this->module);

        $this->deleteTemplateOnForm($this->module, $template);

        $this->assertFileNotExists($template->getFolder(true));
    }
}
