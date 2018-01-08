<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group bitrix_files */
class BitrixSiteCreateFormFilesTest extends BitrixTestCase{

    use DatabaseTransactions;

    function setUp(){
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    function smn_can_create_bitrix_site(){
        $module = $this->fillNewBitrixSiteForm();

        $dirs = $this->disk()->directories();

        $module->deleteFolder();

        $this->assertTrue(in_array($this->user->bitrix_partner_code.'.ololo_from_test', $dirs));
    }

    /** @test */
    function it_fills_folder_with_necessary_files_at_creation(){
        $module = $this->fillNewBitrixSiteForm();

        $dirName     = $module->getFolder();
        $partnerCode = $module->PARTNER_CODE;
        $moduleCode  = $module->code;

        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/images/ru/solution.png');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/lang/ru/site/services/.services.php');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/lang/ru/.description.php');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/lang/ru/wizard.php');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/site/public/ru/.htaccess');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/site/public/ru/.left.menu.php');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/site/public/ru/.top.menu.php');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/site/public/ru/_index.php');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/site/services/main/lang/ru/menu.php');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/site/services/main/lang/ru/settings.php');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/site/services/main/lang/ru/site_create.php');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/site/services/main/files.php');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/site/services/main/menu.php');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/site/services/main/settings.php');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/site/services/main/site_create.php');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/site/services/main/template.php');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/site/services/main/theme.php');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/site/services/.htaccess');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/site/services/.services.php');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/.description.php');
        $this->assertFileExists($dirName.'/install/wizards/'.$partnerCode.'/'.$moduleCode.'/wizard.php');

        $module->deleteFolder();
    }
}
