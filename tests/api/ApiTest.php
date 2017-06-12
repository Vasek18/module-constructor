<?php

/**
 * Внимание! Был измененён файл C:\xampp\htdocs\constructor.local\vendor\laravel\passport\src\PassportServiceProvider.php
 * P100Y заменён на P1Y
 */

use App\Models\Modules\Bitrix\BitrixIblocksProps;
use App\Models\Modules\Bitrix\BitrixIblocksPropsVals;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use \Illuminate\Http\UploadedFile;

class ApiTest extends TestCase{

	use DatabaseTransactions;

	protected $headers = [];
	protected $scopes = [];
	protected $token;

	public function setUp(){
		parent::setUp();

		// создаём нового пользователя
		$user = factory(App\Models\User::class)->create();
		$this->user = $user;

		// что-то для самого функционала ключей
		$oauthClientID = DB::table('oauth_clients')->insertGetId([
			'name'                   => 'Modules Constructor Test',
			'secret'                 => str_random(40),
			'redirect'               => 'http://localhost',
			'personal_access_client' => 1,
			'revoked'                => false,
			'created_at'             => new DateTime,
			'updated_at'             => new DateTime,
		]);
		DB::table('oauth_personal_access_clients')->insert([
			'client_id'  => $oauthClientID,
			'created_at' => new DateTime,
			'updated_at' => new DateTime,
		]);

		// создаём пользотелю токен
		$this->token = $this->user->createToken($this->user->id.' Access Token')->accessToken; // создаём новый токен

		// устанавливаем заголовки для авторизации через api
		$this->headers['Accept'] = 'application/json';
		$this->headers['Authorization'] = 'Bearer '.$this->token;
	}

	/** @test */
	public function you_can_auth_with_token(){
		$this->json('GET', '/api/user', [], $this->headers);
		$this->see($this->user->first_name);
	}

	/** @test */
	public function user_can_see_his_modules(){
		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);
		$module2 = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);

		$this->json('GET', '/api/modules', [], $this->headers);

		$this->seeJsonEquals([
			[
				'name'         => $module->name,
				'description'  => $module->description,
				'code'         => $module->code,
				'partner_code' => $module->PARTNER_CODE,
			],
			[
				'name'         => $module2->name,
				'description'  => $module2->description,
				'code'         => $module2->code,
				'partner_code' => $module2->PARTNER_CODE,
			]
		]);
	}

	/** @test */
	public function with_modules_user_get_iblocks_n_components(){
		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);
		$component = factory(App\Models\Modules\Bitrix\BitrixComponent::class)->create(['module_id' => $module->id]);
		$iblock = factory(App\Models\Modules\Bitrix\BitrixInfoblocks::class)->create(['module_id' => $module->id]);

		$this->json('GET', '/api/modules', [], $this->headers);

		$this->seeJsonEquals([
			[
				'name'         => $module->name,
				'description'  => $module->description,
				'code'         => $module->code,
				'partner_code' => $module->PARTNER_CODE,
				'components'   => [
					[
						'name'      => $component->name,
						'code'      => $component->code,
						'namespace' => $component->namespace,
					]
				],
				'iblocks'      => [
					[
						'name' => $iblock->name,
						'code' => $iblock->code,
						'type' => $module->class_name.'_iblock_type',
					]
				]
			]
		]);
	}

	/** @test */
	public function it_can_import_iblock_to_module(){
		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);
		$module = App\Models\Modules\Bitrix\Bitrix::where('id', $module->id)->first();
		$module->createFolder();
		$this->json(
			'POST',
			'/api/modules/'.$module->PARTNER_CODE.'.'.$module->code.'/import/iblock',
			[
				'IBLOCK' => serialize(Array(
					'ID'                 => '40',
					'TIMESTAMP_X'        => '30.10.2016 02:39:21',
					'IBLOCK_TYPE_ID'     => $module->PARTNER_CODE.'_'.$module->code.'_iblock_type',
					'LID'                => 's1',
					'CODE'               => 'test_iblock',
					'NAME'               => 'Тестовый инфоблок',
					'ACTIVE'             => 'Y',
					'SORT'               => '500',
					'LIST_PAGE_URL'      => '#SITE_DIR#/test_iblock/index.php?ID=#IBLOCK_ID#',
					'DETAIL_PAGE_URL'    => '#SITE_DIR#/test_iblock/detail.php?ID=#ELEMENT_ID#',
					'SECTION_PAGE_URL'   => '#SITE_DIR#/test_iblock/list.php?SECTION_ID=#SECTION_ID#',
					'CANONICAL_PAGE_URL' => '',
					'PICTURE'            => '',
					'DESCRIPTION'        => '',
					'DESCRIPTION_TYPE'   => 'text',
					'RSS_TTL'            => '24',
					'RSS_ACTIVE'         => 'Y',
					'RSS_FILE_ACTIVE'    => 'N',
					'RSS_FILE_LIMIT'     => '',
					'RSS_FILE_DAYS'      => '',
					'RSS_YANDEX_ACTIVE'  => 'N',
					'XML_ID'             => '',
					'TMP_ID'             => '',
					'INDEX_ELEMENT'      => 'N',
					'INDEX_SECTION'      => 'N',
					'WORKFLOW'           => 'Y',
					'BIZPROC'            => 'N',
					'SECTION_CHOOSER'    => 'L',
					'LIST_MODE'          => '',
					'RIGHTS_MODE'        => 'S',
					'SECTION_PROPERTY'   => '',
					'PROPERTY_INDEX'     => '',
					'VERSION'            => '1',
					'LAST_CONV_ELEMENT'  => '0',
					'SOCNET_GROUP_ID'    => '',
					'EDIT_FILE_BEFORE'   => '',
					'EDIT_FILE_AFTER'    => '',
					'SECTIONS_NAME'      => 'Разделы',
					'SECTION_NAME'       => 'Раздел',
					'ELEMENTS_NAME'      => 'Элементы',
					'ELEMENT_NAME'       => 'Элемент',
					'ELEMENT_ADD'        => 'Добавить элемент',
					'ELEMENT_EDIT'       => 'Изменить элемент',
					'ELEMENT_DELETE'     => 'Удалить элемент',
					'SECTION_ADD'        => 'Добавить раздел',
					'SECTION_EDIT'       => 'Изменить раздел',
					'SECTION_DELETE'     => 'Удалить раздел',
					'FIELDS'             => Array(
						'IBLOCK_SECTION'                        => Array(
							'NAME'          => 'Привязка к разделам',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => Array(
								'KEEP_IBLOCK_SECTION_ID' => 'N'
							),
						),
						'ACTIVE'                                => Array(
							'NAME'          => 'Активность',
							'IS_REQUIRED'   => 'Y',
							'DEFAULT_VALUE' => 'Y',
						),
						'ACTIVE_FROM'                           => Array(
							'NAME'          => 'Начало активности',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'ACTIVE_TO'                             => Array(
							'NAME'          => 'Окончание активности',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'SORT'                                  => Array(
							'NAME'          => 'Сортировка',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '0',
						),
						'NAME'                                  => Array(
							'NAME'          => 'Название',
							'IS_REQUIRED'   => 'Y',
							'DEFAULT_VALUE' => '',
						),
						'PREVIEW_PICTURE'                       => Array(
							'NAME'          => 'Картинка для анонса',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => Array(
								'FROM_DETAIL'             => 'N',
								'SCALE'                   => 'N',
								'WIDTH'                   => '',
								'HEIGHT'                  => '',
								'IGNORE_ERRORS'           => 'N',
								'METHOD'                  => '',
								'COMPRESSION'             => '',
								'DELETE_WITH_DETAIL'      => 'N',
								'UPDATE_WITH_DETAIL'      => 'N',
								'USE_WATERMARK_TEXT'      => 'N',
								'WATERMARK_TEXT'          => '',
								'WATERMARK_TEXT_FONT'     => '',
								'WATERMARK_TEXT_COLOR'    => '',
								'WATERMARK_TEXT_SIZE'     => '',
								'WATERMARK_TEXT_POSITION' => 'tl',
								'USE_WATERMARK_FILE'      => 'N',
								'WATERMARK_FILE'          => '',
								'WATERMARK_FILE_ALPHA'    => '',
								'WATERMARK_FILE_POSITION' => 'tl',
								'WATERMARK_FILE_ORDER'    => '',
							),
						),
						'PREVIEW_TEXT_TYPE'                     => Array(
							'NAME'          => 'Тип описания для анонса',
							'IS_REQUIRED'   => 'Y',
							'DEFAULT_VALUE' => 'text',
						),
						'PREVIEW_TEXT'                          => Array(
							'NAME'          => 'Описание для анонса',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'DETAIL_PICTURE'                        => Array(
							'NAME'          => 'Детальная картинка',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => Array(
								'SCALE'                   => 'N',
								'WIDTH'                   => '',
								'HEIGHT'                  => '',
								'IGNORE_ERRORS'           => 'N',
								'METHOD'                  => '',
								'COMPRESSION'             => '',
								'USE_WATERMARK_TEXT'      => 'N',
								'WATERMARK_TEXT'          => '',
								'WATERMARK_TEXT_FONT'     => '',
								'WATERMARK_TEXT_COLOR'    => '',
								'WATERMARK_TEXT_SIZE'     => '',
								'WATERMARK_TEXT_POSITION' => 'tl',
								'USE_WATERMARK_FILE'      => 'N',
								'WATERMARK_FILE'          => '',
								'WATERMARK_FILE_ALPHA'    => '',
								'WATERMARK_FILE_POSITION' => 'tl',
								'WATERMARK_FILE_ORDER'    => '',
							),
						),
						'DETAIL_TEXT_TYPE'                      => Array(
							'NAME'          => 'Тип детального описания',
							'IS_REQUIRED'   => 'Y',
							'DEFAULT_VALUE' => 'text',
						),
						'DETAIL_TEXT'                           => Array(
							'NAME'          => 'Детальное описание',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'XML_ID'                                => Array(
							'NAME'          => 'Внешний код',
							'IS_REQUIRED'   => 'Y',
							'DEFAULT_VALUE' => '',
						),
						'CODE'                                  => Array(
							'NAME'          => 'Символьный код',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => Array(
								'UNIQUE'          => 'N',
								'TRANSLITERATION' => 'N',
								'TRANS_LEN'       => '100',
								'TRANS_CASE'      => '',
								'TRANS_SPACE'     => '',
								'TRANS_OTHER'     => '',
								'TRANS_EAT'       => 'N',
								'USE_GOOGLE'      => 'N',
							),
						),
						'TAGS'                                  => Array(
							'NAME'          => 'Теги',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'SECTION_NAME'                          => Array(
							'NAME'          => 'Название',
							'IS_REQUIRED'   => 'Y',
							'DEFAULT_VALUE' => '',
						),
						'SECTION_PICTURE'                       => Array(
							'NAME'          => 'Картинка для анонса',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => Array(
								'FROM_DETAIL'             => 'N',
								'SCALE'                   => 'N',
								'WIDTH'                   => '',
								'HEIGHT'                  => '',
								'IGNORE_ERRORS'           => 'N',
								'METHOD'                  => '',
								'COMPRESSION'             => '',
								'DELETE_WITH_DETAIL'      => 'N',
								'UPDATE_WITH_DETAIL'      => 'N',
								'USE_WATERMARK_TEXT'      => 'N',
								'WATERMARK_TEXT'          => '',
								'WATERMARK_TEXT_FONT'     => '',
								'WATERMARK_TEXT_COLOR'    => '',
								'WATERMARK_TEXT_SIZE'     => '',
								'WATERMARK_TEXT_POSITION' => 'tl',
								'USE_WATERMARK_FILE'      => 'N',
								'WATERMARK_FILE'          => '',
								'WATERMARK_FILE_ALPHA'    => '',
								'WATERMARK_FILE_POSITION' => 'tl',
								'WATERMARK_FILE_ORDER'    => '',
							),
						),
						'SECTION_DESCRIPTION_TYPE'              => Array(
							'NAME'          => 'Тип описания',
							'IS_REQUIRED'   => 'Y',
							'DEFAULT_VALUE' => 'text',
						),
						'SECTION_DESCRIPTION'                   => Array(
							'NAME'          => 'Описание',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'SECTION_DETAIL_PICTURE'                => Array(
							'NAME'          => 'Детальная картинка',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => Array(
								'SCALE'                   => 'N',
								'WIDTH'                   => '',
								'HEIGHT'                  => '',
								'IGNORE_ERRORS'           => 'N',
								'METHOD'                  => '',
								'COMPRESSION'             => '',
								'USE_WATERMARK_TEXT'      => 'N',
								'WATERMARK_TEXT'          => '',
								'WATERMARK_TEXT_FONT'     => '',
								'WATERMARK_TEXT_COLOR'    => '',
								'WATERMARK_TEXT_SIZE'     => '',
								'WATERMARK_TEXT_POSITION' => 'tl',
								'USE_WATERMARK_FILE'      => 'N',
								'WATERMARK_FILE'          => '',
								'WATERMARK_FILE_ALPHA'    => '',
								'WATERMARK_FILE_POSITION' => 'tl',
								'WATERMARK_FILE_ORDER'    => '',
							),
						),
						'SECTION_XML_ID'                        => Array(
							'NAME'          => 'Внешний код',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'SECTION_CODE'                          => Array(
							'NAME'          => 'Символьный код',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => Array(
								'UNIQUE'          => 'N',
								'TRANSLITERATION' => 'N',
								'TRANS_LEN'       => '100',
								'TRANS_CASE'      => '',
								'TRANS_SPACE'     => '',
								'TRANS_OTHER'     => '',
								'TRANS_EAT'       => 'N',
								'USE_GOOGLE'      => 'N',
							),
						),
						'LOG_SECTION_ADD'                       => Array(
							'NAME'          => 'LOG_SECTION_ADD',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'LOG_SECTION_EDIT'                      => Array(
							'NAME'          => 'LOG_SECTION_EDIT',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'LOG_SECTION_DELETE'                    => Array(
							'NAME'          => 'LOG_SECTION_DELETE',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'LOG_ELEMENT_ADD'                       => Array(
							'NAME'          => 'LOG_ELEMENT_ADD',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'LOG_ELEMENT_EDIT'                      => Array(
							'NAME'          => 'LOG_ELEMENT_EDIT',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'LOG_ELEMENT_DELETE'                    => Array(
							'NAME'          => 'LOG_ELEMENT_DELETE',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'XML_IMPORT_START_TIME'                 => Array(
							'NAME'          => 'XML_IMPORT_START_TIME',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
							'VISIBLE'       => 'N',
						),
						'DETAIL_TEXT_TYPE_ALLOW_CHANGE'         => Array(
							'NAME'          => 'DETAIL_TEXT_TYPE_ALLOW_CHANGE',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => 'N',
							'VISIBLE'       => 'N',
						),
						'PREVIEW_TEXT_TYPE_ALLOW_CHANGE'        => Array(
							'NAME'          => 'PREVIEW_TEXT_TYPE_ALLOW_CHANGE',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => 'N',
							'VISIBLE'       => 'N',
						),
						'SECTION_DESCRIPTION_TYPE_ALLOW_CHANGE' => Array(
							'NAME'          => 'SECTION_DESCRIPTION_TYPE_ALLOW_CHANGE',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => 'Y',
							'VISIBLE'       => 'N',
						),
					),
				))
			],
			$this->headers
		);

		// проверка ответа
		$this->seeJsonEquals(
			[
				'success' => true,
				'iblock'  => [
					'code' => 'test_iblock'
				],
			]
		);

		// проверка в интерфейсе (todo?)

		// проверка в файлах
		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$this->assertEquals($gottenInstallationFuncCodeArray[0]['CODE'], 'test_iblock');
		$this->assertEquals($installFileLangArr[strtoupper($module->PARTNER_CODE.'_'.$module->code).'_IBLOCK_TEST_IBLOCK_NAME'], 'Тестовый инфоблок');

		// не забываем удалить папку с модулем
		$module->deleteFolder();
	}

	/** @test */
	public function it_can_import_iblock_with_props_to_module(){
		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);
		$module = App\Models\Modules\Bitrix\Bitrix::where('id', $module->id)->first();
		$module->createFolder();
		$this->json(
			'POST',
			'/api/modules/'.$module->PARTNER_CODE.'.'.$module->code.'/import/iblock',
			[
				'IBLOCK'     => serialize(Array(
					'ID'                 => '40',
					'TIMESTAMP_X'        => '30.10.2016 02:39:21',
					'IBLOCK_TYPE_ID'     => $module->PARTNER_CODE.'_'.$module->code.'_iblock_type',
					'LID'                => 's1',
					'CODE'               => 'test_iblock',
					'NAME'               => 'Тестовый инфоблок',
					'ACTIVE'             => 'Y',
					'SORT'               => '500',
					'LIST_PAGE_URL'      => '#SITE_DIR#/test_iblock/index.php?ID=#IBLOCK_ID#',
					'DETAIL_PAGE_URL'    => '#SITE_DIR#/test_iblock/detail.php?ID=#ELEMENT_ID#',
					'SECTION_PAGE_URL'   => '#SITE_DIR#/test_iblock/list.php?SECTION_ID=#SECTION_ID#',
					'CANONICAL_PAGE_URL' => '',
					'PICTURE'            => '',
					'DESCRIPTION'        => '',
					'DESCRIPTION_TYPE'   => 'text',
					'RSS_TTL'            => '24',
					'RSS_ACTIVE'         => 'Y',
					'RSS_FILE_ACTIVE'    => 'N',
					'RSS_FILE_LIMIT'     => '',
					'RSS_FILE_DAYS'      => '',
					'RSS_YANDEX_ACTIVE'  => 'N',
					'XML_ID'             => '',
					'TMP_ID'             => '',
					'INDEX_ELEMENT'      => 'N',
					'INDEX_SECTION'      => 'N',
					'WORKFLOW'           => 'Y',
					'BIZPROC'            => 'N',
					'SECTION_CHOOSER'    => 'L',
					'LIST_MODE'          => '',
					'RIGHTS_MODE'        => 'S',
					'SECTION_PROPERTY'   => '',
					'PROPERTY_INDEX'     => '',
					'VERSION'            => '1',
					'LAST_CONV_ELEMENT'  => '0',
					'SOCNET_GROUP_ID'    => '',
					'EDIT_FILE_BEFORE'   => '',
					'EDIT_FILE_AFTER'    => '',
					'SECTIONS_NAME'      => 'Разделы',
					'SECTION_NAME'       => 'Раздел',
					'ELEMENTS_NAME'      => 'Элементы',
					'ELEMENT_NAME'       => 'Элемент',
					'ELEMENT_ADD'        => 'Добавить элемент',
					'ELEMENT_EDIT'       => 'Изменить элемент',
					'ELEMENT_DELETE'     => 'Удалить элемент',
					'SECTION_ADD'        => 'Добавить раздел',
					'SECTION_EDIT'       => 'Изменить раздел',
					'SECTION_DELETE'     => 'Удалить раздел',
					'FIELDS'             => Array(
						'IBLOCK_SECTION'                        => Array(
							'NAME'          => 'Привязка к разделам',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => Array(
								'KEEP_IBLOCK_SECTION_ID' => 'N'
							),
						),
						'ACTIVE'                                => Array(
							'NAME'          => 'Активность',
							'IS_REQUIRED'   => 'Y',
							'DEFAULT_VALUE' => 'Y',
						),
						'ACTIVE_FROM'                           => Array(
							'NAME'          => 'Начало активности',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'ACTIVE_TO'                             => Array(
							'NAME'          => 'Окончание активности',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'SORT'                                  => Array(
							'NAME'          => 'Сортировка',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '0',
						),
						'NAME'                                  => Array(
							'NAME'          => 'Название',
							'IS_REQUIRED'   => 'Y',
							'DEFAULT_VALUE' => '',
						),
						'PREVIEW_PICTURE'                       => Array(
							'NAME'          => 'Картинка для анонса',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => Array(
								'FROM_DETAIL'             => 'N',
								'SCALE'                   => 'N',
								'WIDTH'                   => '',
								'HEIGHT'                  => '',
								'IGNORE_ERRORS'           => 'N',
								'METHOD'                  => '',
								'COMPRESSION'             => '',
								'DELETE_WITH_DETAIL'      => 'N',
								'UPDATE_WITH_DETAIL'      => 'N',
								'USE_WATERMARK_TEXT'      => 'N',
								'WATERMARK_TEXT'          => '',
								'WATERMARK_TEXT_FONT'     => '',
								'WATERMARK_TEXT_COLOR'    => '',
								'WATERMARK_TEXT_SIZE'     => '',
								'WATERMARK_TEXT_POSITION' => 'tl',
								'USE_WATERMARK_FILE'      => 'N',
								'WATERMARK_FILE'          => '',
								'WATERMARK_FILE_ALPHA'    => '',
								'WATERMARK_FILE_POSITION' => 'tl',
								'WATERMARK_FILE_ORDER'    => '',
							),
						),
						'PREVIEW_TEXT_TYPE'                     => Array(
							'NAME'          => 'Тип описания для анонса',
							'IS_REQUIRED'   => 'Y',
							'DEFAULT_VALUE' => 'text',
						),
						'PREVIEW_TEXT'                          => Array(
							'NAME'          => 'Описание для анонса',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'DETAIL_PICTURE'                        => Array(
							'NAME'          => 'Детальная картинка',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => Array(
								'SCALE'                   => 'N',
								'WIDTH'                   => '',
								'HEIGHT'                  => '',
								'IGNORE_ERRORS'           => 'N',
								'METHOD'                  => '',
								'COMPRESSION'             => '',
								'USE_WATERMARK_TEXT'      => 'N',
								'WATERMARK_TEXT'          => '',
								'WATERMARK_TEXT_FONT'     => '',
								'WATERMARK_TEXT_COLOR'    => '',
								'WATERMARK_TEXT_SIZE'     => '',
								'WATERMARK_TEXT_POSITION' => 'tl',
								'USE_WATERMARK_FILE'      => 'N',
								'WATERMARK_FILE'          => '',
								'WATERMARK_FILE_ALPHA'    => '',
								'WATERMARK_FILE_POSITION' => 'tl',
								'WATERMARK_FILE_ORDER'    => '',
							),
						),
						'DETAIL_TEXT_TYPE'                      => Array(
							'NAME'          => 'Тип детального описания',
							'IS_REQUIRED'   => 'Y',
							'DEFAULT_VALUE' => 'text',
						),
						'DETAIL_TEXT'                           => Array(
							'NAME'          => 'Детальное описание',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'XML_ID'                                => Array(
							'NAME'          => 'Внешний код',
							'IS_REQUIRED'   => 'Y',
							'DEFAULT_VALUE' => '',
						),
						'CODE'                                  => Array(
							'NAME'          => 'Символьный код',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => Array(
								'UNIQUE'          => 'N',
								'TRANSLITERATION' => 'N',
								'TRANS_LEN'       => '100',
								'TRANS_CASE'      => '',
								'TRANS_SPACE'     => '',
								'TRANS_OTHER'     => '',
								'TRANS_EAT'       => 'N',
								'USE_GOOGLE'      => 'N',
							),
						),
						'TAGS'                                  => Array(
							'NAME'          => 'Теги',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'SECTION_NAME'                          => Array(
							'NAME'          => 'Название',
							'IS_REQUIRED'   => 'Y',
							'DEFAULT_VALUE' => '',
						),
						'SECTION_PICTURE'                       => Array(
							'NAME'          => 'Картинка для анонса',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => Array(
								'FROM_DETAIL'             => 'N',
								'SCALE'                   => 'N',
								'WIDTH'                   => '',
								'HEIGHT'                  => '',
								'IGNORE_ERRORS'           => 'N',
								'METHOD'                  => '',
								'COMPRESSION'             => '',
								'DELETE_WITH_DETAIL'      => 'N',
								'UPDATE_WITH_DETAIL'      => 'N',
								'USE_WATERMARK_TEXT'      => 'N',
								'WATERMARK_TEXT'          => '',
								'WATERMARK_TEXT_FONT'     => '',
								'WATERMARK_TEXT_COLOR'    => '',
								'WATERMARK_TEXT_SIZE'     => '',
								'WATERMARK_TEXT_POSITION' => 'tl',
								'USE_WATERMARK_FILE'      => 'N',
								'WATERMARK_FILE'          => '',
								'WATERMARK_FILE_ALPHA'    => '',
								'WATERMARK_FILE_POSITION' => 'tl',
								'WATERMARK_FILE_ORDER'    => '',
							),
						),
						'SECTION_DESCRIPTION_TYPE'              => Array(
							'NAME'          => 'Тип описания',
							'IS_REQUIRED'   => 'Y',
							'DEFAULT_VALUE' => 'text',
						),
						'SECTION_DESCRIPTION'                   => Array(
							'NAME'          => 'Описание',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'SECTION_DETAIL_PICTURE'                => Array(
							'NAME'          => 'Детальная картинка',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => Array(
								'SCALE'                   => 'N',
								'WIDTH'                   => '',
								'HEIGHT'                  => '',
								'IGNORE_ERRORS'           => 'N',
								'METHOD'                  => '',
								'COMPRESSION'             => '',
								'USE_WATERMARK_TEXT'      => 'N',
								'WATERMARK_TEXT'          => '',
								'WATERMARK_TEXT_FONT'     => '',
								'WATERMARK_TEXT_COLOR'    => '',
								'WATERMARK_TEXT_SIZE'     => '',
								'WATERMARK_TEXT_POSITION' => 'tl',
								'USE_WATERMARK_FILE'      => 'N',
								'WATERMARK_FILE'          => '',
								'WATERMARK_FILE_ALPHA'    => '',
								'WATERMARK_FILE_POSITION' => 'tl',
								'WATERMARK_FILE_ORDER'    => '',
							),
						),
						'SECTION_XML_ID'                        => Array(
							'NAME'          => 'Внешний код',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'SECTION_CODE'                          => Array(
							'NAME'          => 'Символьный код',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => Array(
								'UNIQUE'          => 'N',
								'TRANSLITERATION' => 'N',
								'TRANS_LEN'       => '100',
								'TRANS_CASE'      => '',
								'TRANS_SPACE'     => '',
								'TRANS_OTHER'     => '',
								'TRANS_EAT'       => 'N',
								'USE_GOOGLE'      => 'N',
							),
						),
						'LOG_SECTION_ADD'                       => Array(
							'NAME'          => 'LOG_SECTION_ADD',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'LOG_SECTION_EDIT'                      => Array(
							'NAME'          => 'LOG_SECTION_EDIT',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'LOG_SECTION_DELETE'                    => Array(
							'NAME'          => 'LOG_SECTION_DELETE',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'LOG_ELEMENT_ADD'                       => Array(
							'NAME'          => 'LOG_ELEMENT_ADD',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'LOG_ELEMENT_EDIT'                      => Array(
							'NAME'          => 'LOG_ELEMENT_EDIT',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'LOG_ELEMENT_DELETE'                    => Array(
							'NAME'          => 'LOG_ELEMENT_DELETE',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
						),
						'XML_IMPORT_START_TIME'                 => Array(
							'NAME'          => 'XML_IMPORT_START_TIME',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => '',
							'VISIBLE'       => 'N',
						),
						'DETAIL_TEXT_TYPE_ALLOW_CHANGE'         => Array(
							'NAME'          => 'DETAIL_TEXT_TYPE_ALLOW_CHANGE',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => 'N',
							'VISIBLE'       => 'N',
						),
						'PREVIEW_TEXT_TYPE_ALLOW_CHANGE'        => Array(
							'NAME'          => 'PREVIEW_TEXT_TYPE_ALLOW_CHANGE',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => 'N',
							'VISIBLE'       => 'N',
						),
						'SECTION_DESCRIPTION_TYPE_ALLOW_CHANGE' => Array(
							'NAME'          => 'SECTION_DESCRIPTION_TYPE_ALLOW_CHANGE',
							'IS_REQUIRED'   => 'N',
							'DEFAULT_VALUE' => 'Y',
							'VISIBLE'       => 'N',
						),
					),
				)),
				'PROPERTIES' => serialize(Array(
					Array(
						'ID'                 => '102',
						'TIMESTAMP_X'        => '2017-05-20 23:50:47',
						'IBLOCK_ID'          => '20',
						'NAME'               => 'Предложный падеж',
						'ACTIVE'             => 'Y',
						'SORT'               => '400',
						'CODE'               => 'WHERE',
						'DEFAULT_VALUE'      => '',
						'PROPERTY_TYPE'      => 'S',
						'ROW_COUNT'          => '1',
						'COL_COUNT'          => '30',
						'LIST_TYPE'          => 'L',
						'MULTIPLE'           => 'N',
						'XML_ID'             => '102',
						'FILE_TYPE'          => '',
						'MULTIPLE_CNT'       => '5',
						'TMP_ID'             => '',
						'LINK_IBLOCK_ID'     => '0',
						'WITH_DESCRIPTION'   => 'N',
						'SEARCHABLE'         => 'N',
						'FILTRABLE'          => 'N',
						'IS_REQUIRED'        => 'N',
						'VERSION'            => '1',
						'USER_TYPE'          => '',
						'USER_TYPE_SETTINGS' => '',
						'HINT'               => '',
					),
					Array(
						'ID'                 => '105',
						'TIMESTAMP_X'        => '2016 - 10 - 06 23:26:15',
						'IBLOCK_ID'          => '20',
						'NAME'               => 'Адрес',
						'ACTIVE'             => 'Y',
						'SORT'               => '500',
						'CODE'               => 'ADRES',
						'DEFAULT_VALUE'      => Array(
							'TEXT' => '',
							'TYPE' => 'HTML',
						),
						'PROPERTY_TYPE'      => 'S',
						'ROW_COUNT'          => '1',
						'COL_COUNT'          => '30',
						'LIST_TYPE'          => 'L',
						'MULTIPLE'           => 'N',
						'XML_ID'             => '105',
						'FILE_TYPE'          => '',
						'MULTIPLE_CNT'       => '5',
						'TMP_ID'             => '',
						'LINK_IBLOCK_ID'     => '0',
						'WITH_DESCRIPTION'   => 'N',
						'SEARCHABLE'         => 'N',
						'FILTRABLE'          => 'N',
						'IS_REQUIRED'        => 'N',
						'VERSION'            => '1',
						'USER_TYPE'          => 'HTML',
						'USER_TYPE_SETTINGS' => Array(
							'height' => '200',
						),
						'HINT'               => '',
					),
					Array(
						'ID'                 => '106',
						'TIMESTAMP_X'        => '2016 - 10 - 06 23:26:15',
						'IBLOCK_ID'          => '20',
						'NAME'               => 'Центр региона',
						'ACTIVE'             => 'Y',
						'SORT'               => '2000',
						'CODE'               => 'CENTR_REGIONA',
						'DEFAULT_VALUE'      => '',
						'PROPERTY_TYPE'      => 'S',
						'ROW_COUNT'          => '1',
						'COL_COUNT'          => '30',
						'LIST_TYPE'          => 'L',
						'MULTIPLE'           => 'N',
						'XML_ID'             => '106',
						'FILE_TYPE'          => '',
						'MULTIPLE_CNT'       => '5',
						'TMP_ID'             => '',
						'LINK_IBLOCK_ID'     => '0',
						'WITH_DESCRIPTION'   => 'N',
						'SEARCHABLE'         => 'N',
						'FILTRABLE'          => 'N',
						'IS_REQUIRED'        => 'N',
						'VERSION'            => '1',
						'USER_TYPE'          => 'map_google',
						'USER_TYPE_SETTINGS' => Array(
							'API_KEY' => '',
						),
						'HINT'               => '',
					),
					Array(
						'ID'                 => '224',
						'TIMESTAMP_X'        => '2017-05-20 23:50:47',
						'IBLOCK_ID'          => '20',
						'NAME'               => 'Избранный?',
						'ACTIVE'             => 'Y',
						'SORT'               => '600',
						'CODE'               => 'CHOSEN_ONE',
						'DEFAULT_VALUE'      => '',
						'PROPERTY_TYPE'      => 'L',
						'ROW_COUNT'          => '1',
						'COL_COUNT'          => '30',
						'LIST_TYPE'          => 'C',
						'MULTIPLE'           => 'N',
						'XML_ID'             => '',
						'FILE_TYPE'          => '',
						'MULTIPLE_CNT'       => '5',
						'TMP_ID'             => '',
						'LINK_IBLOCK_ID'     => '0',
						'WITH_DESCRIPTION'   => 'N',
						'SEARCHABLE'         => 'N',
						'FILTRABLE'          => 'N',
						'IS_REQUIRED'        => 'N',
						'VERSION'            => '1',
						'USER_TYPE'          => '',
						'USER_TYPE_SETTINGS' => '',
						'HINT'               => '',
						'VALUES'             => Array(
							Array(
								'ID'           => '60',
								'~ID'          => '60',
								'PROPERTY_ID'  => '224',
								'~PROPERTY_ID' => '224',
								'VALUE'        => 'Y',
								'~VALUE'       => 'Y',
								'DEF'          => 'N',
								'~DEF'         => 'N',
								'SORT'         => '500',
								'~SORT'        => '500',
								'XML_ID'       => '49a3fb6c929ec3dca70c46f214626525',
								'~XML_ID'      => '49a3fb6c929ec3dca70c46f214626525',
								'TMP_ID'       => '',
								'~TMP_ID'      => '',
								'EXTERNAL_ID'  => '49a3fb6c929ec3dca70c46f214626525',
								'~EXTERNAL_ID' => '49a3fb6c929ec3dca70c46f214626525',
							)
						)
					)
				))
			],
			$this->headers
		);

		// dd($this->response->getContent());
		// проверка ответа
		$this->seeJsonEquals(
			[
				'success' => true,
				'iblock'  => [
					'code' => 'test_iblock'
				],
			]
		);

		// проверка в файлах
		$installFileLangArr = $this->getLangFileArray($module);
		$gottenInstallationPropsFuncCodeArray = $this->getIblockPropsCreationFuncCallParamsArray($module);
		$gottenInstallationPropsValsFuncCodeArray = $this->getIblockPropsValsCreationFuncCallParamsArray($module);
		$prop = BitrixIblocksProps::where('CODE', 'WHERE')->first();
		$prop1 = BitrixIblocksProps::where('CODE', 'ADRES')->first();
		$prop2 = BitrixIblocksProps::where('CODE', 'CENTR_REGIONA')->first();
		$prop3 = BitrixIblocksProps::where('CODE', 'CHOSEN_ONE')->first();
		$val = BitrixIblocksPropsVals::where('value', 'Y')->first();

		$this->assertEquals($gottenInstallationPropsFuncCodeArray[0]['CODE'], 'WHERE');
		$this->assertEquals($gottenInstallationPropsFuncCodeArray[1]['CODE'], 'ADRES');
		$this->assertEquals($gottenInstallationPropsFuncCodeArray[2]['CODE'], 'CENTR_REGIONA');
		$this->assertEquals($gottenInstallationPropsFuncCodeArray[3]['CODE'], 'CHOSEN_ONE');
		$this->assertEquals($gottenInstallationPropsFuncCodeArray[0]['SORT'], '400');
		$this->assertEquals($gottenInstallationPropsFuncCodeArray[1]['SORT'], '500');
		$this->assertEquals($gottenInstallationPropsFuncCodeArray[2]['SORT'], '2000');
		$this->assertEquals($gottenInstallationPropsFuncCodeArray[0]['PROPERTY_TYPE'], 'S');
		$this->assertEquals($gottenInstallationPropsFuncCodeArray[1]['PROPERTY_TYPE'], 'S');
		$this->assertEquals($gottenInstallationPropsFuncCodeArray[2]['PROPERTY_TYPE'], 'S');
		$this->assertEquals($gottenInstallationPropsFuncCodeArray[3]['PROPERTY_TYPE'], 'L');
		$this->assertEquals($gottenInstallationPropsFuncCodeArray[0]['USER_TYPE'], '');
		$this->assertEquals($gottenInstallationPropsFuncCodeArray[1]['USER_TYPE'], 'HTML');
		$this->assertEquals($gottenInstallationPropsFuncCodeArray[2]['USER_TYPE'], 'map_google');
		$this->assertEquals($gottenInstallationPropsFuncCodeArray[3]['USER_TYPE'], '');

		$this->assertEquals($installFileLangArr[$prop->lang_key.'_NAME'], 'Предложный падеж');
		$this->assertEquals($installFileLangArr[$prop1->lang_key.'_NAME'], 'Адрес');
		$this->assertEquals($installFileLangArr[$prop2->lang_key.'_NAME'], 'Центр региона');
		$this->assertEquals($installFileLangArr[$prop3->lang_key.'_NAME'], 'Избранный?');
		$this->assertEquals($installFileLangArr[$val->lang_key.'_VALUE'], 'Y');

		// не забываем удалить папку с модулем
		$module->deleteFolder();
	}

	/** @test */
	public function it_can_import_component_to_module(){
		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $this->user->id]);
		$module = App\Models\Modules\Bitrix\Bitrix::where('id', $module->id)->first();
		$module->createFolder();

		// не передаётся файл
		$testFileFolder = public_path().'/for_tests/';
		$testFileName = 'bitrix_catalog.section.zip';
		$copiedTestFileName = 'bitrix_catalog.section2.zip';
		copy($testFileFolder.$testFileName, $testFileFolder.$copiedTestFileName);
		$this->json(
			'POST',
			'/api/modules/'.$module->PARTNER_CODE.'.'.$module->code.'/import/component',
			[
				'namespace' => $module->PARTNER_CODE.'.'.$module->code,
				'archive'   => new UploadedFile($testFileFolder.$copiedTestFileName, $copiedTestFileName, 'application/octet-stream', filesize($testFileFolder.$copiedTestFileName), null, true)
			],
			$this->headers
		);

		// проверка ответа
		$this->seeJsonEquals(
			[
				'success'   => true,
				'component' => [
					'code' => 'catalog.section'
				],
			]
		);

		// проверка того, что компонент есть
		$this->assertTrue(file_exists($module->getFolder(true).DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.$module->PARTNER_CODE.'.'.$module->code.DIRECTORY_SEPARATOR.'catalog.section'.DIRECTORY_SEPARATOR));

		// не забываем удалить папку с модулем
		$module->deleteFolder();
	}

	/** @test */
	public function it_can_import_adminpage_to_module(){

	}

	/** @test */
	public function it_can_import_otherfile_to_module(){

	}
}