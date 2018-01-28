<?php

use App\Models\Modules\Bitrix\BitrixIblocksElements;
use App\Models\Modules\Bitrix\BitrixIblocksPropsVals;
use App\Models\Modules\Bitrix\BitrixIblocksSections;
use App\Models\Modules\Bitrix\BitrixInfoblocks;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Helpers\vArrParse;
use App\Helpers\vFuncParse;
use App\Models\Modules\Bitrix\BitrixIblocksProps;

/** @group bitrix_files */
class BitrixInfoblockXMLImportFilesTest extends BitrixTestCase{

    use DatabaseTransactions;

    protected $path = '/data_storage';

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

    public function importFile($file){
        $this->visit('/my-bitrix/'.$this->module->id.$this->path);
        $this->visit(action('Modules\Bitrix\BitrixDataStorageController@index', [$this->module]));
        $this->attach($file, 'file');
        $this->press('import');
    }

    function getIblockElementsCreationFuncCallParamsArray($module){
        $answer                     = [];
        $installationFileContent    = file_get_contents($module->getFolder(true).'/install/index.php');
        $gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
        // dd($installationFileContent);

        preg_match_all('/\$this\-\>createIblockElement\(([^\;]+)\);/is', $gottenInstallationFuncCode, $matches);
        // dd($matches[1]);
        foreach ($matches[1] as $gottenInstallationFuncCodePart){
            $answer[] = vArrParse::parseFromText($gottenInstallationFuncCodePart);
        }

        return $answer;
    }

    function getIblockSectionsCreationFuncCallParamsArray($module){
        $answer                     = [];
        $installationFileContent    = file_get_contents($module->getFolder(true).'/install/index.php');
        $gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
        // dd($installationFileContent);

        preg_match_all('/\$this\-\>createIblockSection\(([^\;]+)\);/is', $gottenInstallationFuncCode, $matches);
        // dd($matches[1]);
        foreach ($matches[1] as $gottenInstallationFuncCodePart){
            $answer[] = vArrParse::parseFromText($gottenInstallationFuncCodePart);
        }

        return $answer;
    }

    /** @test */
    function it_imports_main_iblock_params(){
        $file = public_path().'/for_tests/test_iblock.xml';
        $this->visit('/my-bitrix/'.$this->module->id.$this->path);
        $this->attach($file, 'file');
        $this->press('import');

        $gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
        $installFileLangArr              = $this->getLangFileArray($this->module);

        $expectedInstallationFuncCodeArray = [
            "IBLOCK_TYPE_ID"     => '$iblockType',
            "ACTIVE"             => "Y",
            "LID"                => '$this->getSitesIdsArray()',
            "CODE"               => "test",
            "NAME"               => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TEST_NAME")',
            "SORT"               => "500",
            "LIST_PAGE_URL"      => "#SITE_DIR#/test/",
            "SECTION_PAGE_URL"   => "#SITE_DIR#/test/#SECTION_CODE_PATH#/",
            "DETAIL_PAGE_URL"    => "#SITE_DIR#/test/#SECTION_CODE_PATH#/#CODE#.html",
            "CANONICAL_PAGE_URL" => 'canon"',
            // todo
            // "INDEX_SECTION"      => "Y",
            // "INDEX_ELEMENT"      => "Y",
            // "FIELDS"             => Array(
            // 	"ACTIVE"            => Array(
            // 		"DEFAULT_VALUE" => "Y",
            // 	),
            // 	"PREVIEW_TEXT_TYPE" => Array(
            // 		"DEFAULT_VALUE" => "text",
            // 	),
            // 	"DETAIL_TEXT_TYPE"  => Array(
            // 		"DEFAULT_VALUE" => "text",
            // 	),
            // ),
            // "GROUP_ID"           => [
            // 	2 => "R"
            // ]
        ];

        $this->assertEquals(1, count($gottenInstallationFuncCodeArray));
        $this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
        $this->assertArrayHasKey($this->module->lang_key.'_IBLOCK_TEST_NAME', $installFileLangArr);
        $this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TEST_NAME'], 'Тест');
    }

    /** @test */
    function it_imports_iblock_properties(){
        $file = public_path().'/for_tests/test_iblock.xml';
        $this->visit('/my-bitrix/'.$this->module->id.$this->path);
        $this->attach($file, 'file');
        $this->press('import');

        $prop                                 = BitrixIblocksProps::where('code', 'TESTOVOE_SVOISVTO')->first();
        $prop2                                = BitrixIblocksProps::where('code', 'ANOTHER_ONE')->first();
        $gottenInstallationPropsFuncCodeArray = $this->getIblockPropsCreationFuncCallParamsArray($this->module);
        $installFileLangArr                   = $this->getLangFileArray($this->module);

        $expectedPropCreationCodeArray  = [
            "IBLOCK_ID"     => '$iblock'.$prop->iblock->id.'ID',
            "ACTIVE"        => "Y",
            "SORT"          => "400",
            "CODE"          => "TESTOVOE_SVOISVTO",
            "NAME"          => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TEST_PARAM_'.$prop->id.'_NAME")',
            "PROPERTY_TYPE" => "S",
            "USER_TYPE"     => "",
            "MULTIPLE"      => "N",
            "IS_REQUIRED"   => "N",
        ];
        $expectedPropCreationCodeArray2 = [
            "IBLOCK_ID"     => '$iblock'.$prop->iblock->id.'ID',
            "ACTIVE"        => "Y",
            "SORT"          => "500",
            "CODE"          => "ANOTHER_ONE",
            "NAME"          => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TEST_PARAM_'.$prop2->id.'_NAME")',
            "PROPERTY_TYPE" => "E",
            "USER_TYPE"     => "",
            "MULTIPLE"      => "Y",
            "IS_REQUIRED"   => "Y",
        ];

        $this->assertEquals($expectedPropCreationCodeArray, $gottenInstallationPropsFuncCodeArray[0], 'Prop array doesnt match');
        $this->assertArraySubset([$this->module->lang_key.'_IBLOCK_TEST_PARAM_'.$prop->id.'_NAME' => 'Тестовое свойство'], $installFileLangArr);
        $this->assertEquals($expectedPropCreationCodeArray2, $gottenInstallationPropsFuncCodeArray[1], 'Prop array doesnt match');
        $this->assertArraySubset([$this->module->lang_key.'_IBLOCK_TEST_PARAM_'.$prop2->id.'_NAME' => 'Ещё свойство'], $installFileLangArr);
    }

    /** @test */
    function it_imports_iblock_elements(){
        $file = public_path().'/for_tests/test_iblock.xml';
        $this->visit('/my-bitrix/'.$this->module->id.$this->path);
        $this->attach($file, 'file');
        $this->press('import');

        $iblock                                  = BitrixInfoblocks::where('code', "test")->first();
        $gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);
        $installFileLangArr                      = $this->getLangFileArray($this->module);
        $element                                 = BitrixIblocksElements::where('name', 'Тест')->first();
        $element2                                = BitrixIblocksElements::where('code', 'ololo')->first();
        $prop                                    = BitrixIblocksProps::where('code', 'TESTOVOE_SVOISVTO')->first();
        $prop2                                   = BitrixIblocksProps::where('code', 'ANOTHER_ONE')->first();

        $expectedInstallationElementsFuncCodeArray  = [
            "IBLOCK_ID"       => '$iblock'.$iblock->id.'ID',
            "ACTIVE"          => "Y",
            "SORT"            => "400",
            "CODE"            => "",
            "NAME"            => 'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element->id.'_NAME")',
            "PROPERTY_VALUES" => Array(
                '$prop'.$prop->id.'ID'  => 'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE")',
                '$prop'.$prop2->id.'ID' => Array(
                    'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop2->id.'_VALUE_0")',
                    'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop2->id.'_VALUE_1")',
                )
            )
        ];
        $expectedInstallationElementsFuncCodeArray2 = [
            "IBLOCK_ID"       => '$iblock'.$iblock->id.'ID',
            "ACTIVE"          => "Y",
            "SORT"            => "500",
            "CODE"            => "ololo",
            "NAME"            => 'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element2->id.'_NAME")',
            "PROPERTY_VALUES" => Array(
                '$prop'.$prop2->id.'ID' => 'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element2->id.'_PROP_'.$prop2->id.'_VALUE")',
            )
        ];

        $this->assertEquals($expectedInstallationElementsFuncCodeArray, $gottenInstallationElementsFuncCodeArray[0]);
        $this->assertEquals($installFileLangArr[$iblock->lang_key.'_ELEMENT_'.$element->id.'_NAME'], 'Тест');
        $this->assertEquals($installFileLangArr[$iblock->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE'], 'Ололо');

        $this->assertEquals($expectedInstallationElementsFuncCodeArray2, $gottenInstallationElementsFuncCodeArray[1]);
        $this->assertEquals($installFileLangArr[$iblock->lang_key.'_ELEMENT_'.$element2->id.'_PROP_'.$prop2->id.'_VALUE'], '447');
    }

    /** @test
     * тест на несколько категорий находится в тесте интерфейса
     */
    function it_imports_iblock_section_with_element_in_it(){
        $file = public_path().'/for_tests/test_iblock_with_section.xml';
        $this->visit('/my-bitrix/'.$this->module->id.$this->path);
        $this->attach($file, 'file');
        $this->press('import');

        $iblock                                  = BitrixInfoblocks::where('code', "test")->first();
        $gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);
        $gottenInstallationSectionsFuncCodeArray = $this->getIblockSectionsCreationFuncCallParamsArray($this->module);
        $installFileLangArr                      = $this->getLangFileArray($this->module);
        $element                                 = BitrixIblocksElements::where('code', 'vlogennyy_element')->first();
        $section                                 = BitrixIblocksSections::where('code', 'testovyy_razdel')->first();
        $prop                                    = BitrixIblocksProps::where('code', 'ANOTHER_ONE')->first();

        $expectedInstallationElementFuncCodeArray = [
            "IBLOCK_ID"         => '$iblock'.$iblock->id.'ID',
            "ACTIVE"            => "Y",
            "SORT"              => "500",
            "CODE"              => "vlogennyy_element",
            "NAME"              => 'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element->id.'_NAME")',
            "IBLOCK_SECTION_ID" => '$section'.$section->id.'ID',
            "PROPERTY_VALUES"   => Array(
                '$prop'.$prop->id.'ID' => 'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE")',
            )
        ];
        $expectedInstallationSectionFuncCodeArray = [
            "IBLOCK_ID" => '$iblock'.$iblock->id.'ID',
            "ACTIVE"    => "Y",
            "SORT"      => "500",
            "CODE"      => "testovyy_razdel",
            "NAME"      => 'Loc::getMessage("'.$iblock->lang_key.'_SECTION_'.$section->id.'_NAME")',
        ];

        $this->assertEquals($expectedInstallationElementFuncCodeArray, $gottenInstallationElementsFuncCodeArray[0]);
        $this->assertEquals($installFileLangArr[$iblock->lang_key.'_ELEMENT_'.$element->id.'_NAME'], 'Вложенный элемент');

        $this->assertEquals($expectedInstallationSectionFuncCodeArray, $gottenInstallationSectionsFuncCodeArray[0]);
        $this->assertEquals($installFileLangArr[$iblock->lang_key.'_SECTION_'.$section->id.'_NAME'], 'Тестовый раздел');
    }

    /** @test */
    function it_imports_empty_iblock(){
        $file = public_path().'/for_tests/test_empty_iblock.xml';
        $this->visit('/my-bitrix/'.$this->module->id.$this->path);
        $this->attach($file, 'file');
        $this->press('import');

        $gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);
        $gottenInstallationSectionsFuncCodeArray = $this->getIblockSectionsCreationFuncCallParamsArray($this->module);

        $this->assertEquals(0, count($gottenInstallationElementsFuncCodeArray));
        $this->assertEquals(0, count($gottenInstallationSectionsFuncCodeArray));
    }

    /** @test */
    function it_imports_list_prop(){
        $file = public_path().'/for_tests/test_iblock_with_list_prop.xml';
        $this->visit('/my-bitrix/'.$this->module->id.$this->path);
        $this->attach($file, 'file');
        $this->press('import');

        $gottenInstallationPropsFuncCodeArray     = $this->getIblockPropsCreationFuncCallParamsArray($this->module);
        $gottenInstallationElementsFuncCodeArray  = $this->getIblockElementsCreationFuncCallParamsArray($this->module);
        $gottenInstallationPropsValsFuncCodeArray = $this->getIblockPropsValsCreationFuncCallParamsArray($this->module);

        $prop     = BitrixIblocksProps::where('code', 'COLOR')->first();
        $val1     = BitrixIblocksPropsVals::where('value', 'Зелёный')->first();
        $val2     = BitrixIblocksPropsVals::where('value', 'Любви')->first();
        $val3     = BitrixIblocksPropsVals::where('value', 'Синий')->first();
        $element  = \App\Models\Modules\Bitrix\BitrixIblocksElements::where('name', 'Трава')->first();
        $element2 = \App\Models\Modules\Bitrix\BitrixIblocksElements::where('name', 'Твоя мамка')->first();

        $propArray = Array(
            "IBLOCK_ID"     => '$iblock'.$prop->iblock->id.'ID',
            "ACTIVE"        => "Y",
            "SORT"          => "500",
            "CODE"          => "COLOR",
            "NAME"          => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TEST_PARAM_'.$prop->id.'_NAME")',
            "PROPERTY_TYPE" => "L",
            "USER_TYPE"     => "",
            "MULTIPLE"      => "N",
            "IS_REQUIRED"   => "N",
        );

        $val1Arr = Array(
            "VALUE"       => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TEST_PARAM_'.$prop->id.'_VAL_'.$val1->id.'_VALUE")',
            "DEF"         => "Y",
            "SORT"        => "100",
            "PROPERTY_ID" => '$prop'.$prop->id."ID",
        );
        $val2Arr = Array(
            "VALUE"       => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TEST_PARAM_'.$prop->id.'_VAL_'.$val2->id.'_VALUE")',
            "DEF"         => "N",
            "SORT"        => "200",
            "PROPERTY_ID" => '$prop'.$prop->id."ID",
        );
        $val3Arr = Array(
            "VALUE"       => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TEST_PARAM_'.$prop->id.'_VAL_'.$val3->id.'_VALUE")',
            "DEF"         => "N",
            "SORT"        => "300",
            "PROPERTY_ID" => '$prop'.$prop->id."ID",
        );

        $elArr1 = Array(
            "IBLOCK_ID"       => '$iblock'.$element->iblock->id.'ID',
            "ACTIVE"          => "Y",
            "SORT"            => "500",
            "CODE"            => "",
            "NAME"            => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TEST_ELEMENT_'.$element->id.'_NAME")',
            "PROPERTY_VALUES" => Array(
                '$prop'.$prop->id.'ID' => '$val'.$val1->id.'ID',
            ),
        );

        $elArr2 = Array(
            "IBLOCK_ID"       => '$iblock'.$element->iblock->id.'ID',
            "ACTIVE"          => "Y",
            "SORT"            => "500",
            "CODE"            => "",
            "NAME"            => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TEST_ELEMENT_'.$element2->id.'_NAME")',
            "PROPERTY_VALUES" => Array(
                '$prop'.$prop->id.'ID' => '$val'.$val2->id.'ID',
            ),
        );

        $this->assertEquals($propArray, $gottenInstallationPropsFuncCodeArray[0]);
        $this->assertEquals($val1Arr, $gottenInstallationPropsValsFuncCodeArray[0]);
        $this->assertEquals($val2Arr, $gottenInstallationPropsValsFuncCodeArray[1]);
        $this->assertEquals($val3Arr, $gottenInstallationPropsValsFuncCodeArray[2]);
        $this->assertEquals($elArr1, $gottenInstallationElementsFuncCodeArray[0]);
        $this->assertEquals($elArr2, $gottenInstallationElementsFuncCodeArray[1]);
    }

    /** @test */
    function it_imports_iblock_with_paket_predlozheniy(){
        $this->importFile(public_path().'/for_tests/test_iblock_var_2.xml');

        $gottenInstallationFuncCodeArray         = $this->getIblockCreationFuncCallParamsArray($this->module);
        $gottenInstallationPropsFuncCodeArray    = $this->getIblockPropsCreationFuncCallParamsArray($this->module);
        $gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);
        $installFileLangArr              = $this->getLangFileArray($this->module);

        $iblock  = BitrixInfoblocks::where('code', 'modules')->first();
        $prop    = BitrixIblocksProps::where('code', 'MARKETPLACE_LINK')->first();
        $element = BitrixIblocksElements::where('code', 'aristov.vregions')->first();

        $expectedInstallationFuncCodeArray = [
            "IBLOCK_TYPE_ID"   => '$iblockType',
            "ACTIVE"           => "Y",
            "LID"              => '$this->getSitesIdsArray()',
            "CODE"             => "modules",
            "NAME"             => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_MODULES_NAME")',
            "SORT"             => "500",
            "LIST_PAGE_URL"    => "#SITE_DIR#/#IBLOCK_CODE#/",
            "SECTION_PAGE_URL" => "#SITE_DIR#/#IBLOCK_CODE#/#CODE#/",
            "DETAIL_PAGE_URL"  => '#SITE_DIR#/#IBLOCK_CODE#/#SECTION_CODE_PATH#/"',
            // todo лишние кавычки
        ];

        $propArray = Array(
            "IBLOCK_ID"     => '$iblock'.$prop->iblock->id.'ID',
            "ACTIVE"        => "Y",
            "SORT"          => "100",
            "CODE"          => "MARKETPLACE_LINK",
            "NAME"          => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_MODULES_PARAM_'.$prop->id.'_NAME")',
            "PROPERTY_TYPE" => "S",
            "USER_TYPE"     => "",
            "MULTIPLE"      => "N",
            "IS_REQUIRED"   => "N",
        );

        $elArr = Array(
            "IBLOCK_ID"       => '$iblock'.$element->iblock->id.'ID',
            "ACTIVE"          => "Y",
            "SORT"            => "100",
            "CODE"            => "aristov.vregions",
            "NAME"            => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_MODULES_ELEMENT_'.$element->id.'_NAME")',
            "PROPERTY_VALUES" => Array(
                '$prop'.$prop->id.'ID' => 'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE")',
            ),
        );

        $this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
        $this->assertEquals($propArray, $gottenInstallationPropsFuncCodeArray[0]);
        $this->assertEquals($elArr['ACTIVE'], $gottenInstallationElementsFuncCodeArray[0]['ACTIVE']);
        $this->assertEquals($elArr['SORT'], $gottenInstallationElementsFuncCodeArray[0]['SORT']);
        $this->assertEquals($elArr['CODE'], $gottenInstallationElementsFuncCodeArray[0]['CODE']);
        $this->assertEquals($elArr['PROPERTY_VALUES']['$prop'.$prop->id.'ID'], $gottenInstallationElementsFuncCodeArray[0]['PROPERTY_VALUES']['$prop'.$prop->id.'ID']);
        $this->assertEquals($installFileLangArr[$iblock->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE'], 'http://marketplace.1c-bitrix.ru/solutions/aristov.vregions/');
    }
}