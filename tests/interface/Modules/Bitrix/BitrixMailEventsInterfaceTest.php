<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Modules\Bitrix\BitrixMailEventsVar;

class BitrixMailEventsInterfaceTest extends BitrixTestCase{

	use DatabaseTransactions;

	protected $path = '/mail_events';
	public $file;

	function setUp(){
		parent::setUp();

		$this->signIn();
		$this->module = $this->fillNewBitrixForm();
	}

	function tearDown(){
		parent::tearDown();

		$this->module->deleteFolder();
	}

	/** @test */
	function author_can_get_to_this_page(){
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs('/my-bitrix/'.$this->module->id.$this->path);
	}

	/** @test */
	function this_is_definitely_page_about_mail_events(){
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->see('Почтовые события');
	}

	/** @test */
	function this_is_definitely_page_about_mail_events_en(){
		$this->setLang('en');

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->see('Mail events');
	}

	/** @test */
	function unauthorized_cannot_get_to_this_page(){
		$this->logOut();

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs('/personal/auth');
	}

	/** @test */
	function not_author_cannot_get_to_this_page_of_anothers_module(){
		$this->signIn(factory(App\Models\User::class)->create());

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs('/personal');
	}

	/** @test */
	function it_returns_mail_event_data_on_detail_page(){
		$mail_event = $this->createMailEventOnForm($this->module, [
			'name' => 'TestMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
		]);

		$this->seePageIs('/my-bitrix/'.$this->module->id.$this->path.'/'.$mail_event->id);
		$this->see('TestMail');
		$this->see('TEST_MAIL');
		$this->see('1808');
		$this->see('TROLOLO - Ololo');
	}

	/** @test */
	function it_returns_mail_event_in_list_on_index_page(){
		$mail_event = $this->createMailEventOnForm($this->module, [
			'name' => 'TestMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
		]);

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
		$this->see('TestMail');
		$this->see('TEST_MAIL');
	}

	/** @test */
	function not_author_cannot_get_to_mail_event_detail_page_of_anothers_module(){
		// есть один модуль с событием
		$mail_event = $this->createMailEventOnForm($this->module, [
			'name' => 'TestMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
		]);
		$this->module->deleteFolder();

		// у другого юзера тоже есть модуль с событием
		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();
		$mail_event2 = $this->createMailEventOnForm($module2, [
			'name' => 'TestMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
		]);
		$module2->deleteFolder();

		// не должно быть такого, чтобы подменив айдишник события на айди события из другого модуля, мы хоть что-то увидели
		$this->visit('/my-bitrix/'.$module2->id.$this->path.'/'.$mail_event->id);
		$this->seePageIs('/personal');
	}

	/** @test */
	function it_can_add_variable(){
		$mail_event = $this->createMailEventOnForm($this->module, [
			'name' => 'TestMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
		]);

		$this->submitForm('add_var', [
			'name' => 'Vasya',
			'code' => 'CREATOR',
		]);

		$this->see('CREATOR - Vasya');
	}

	/** @test */
	function it_can_delete_mail_event(){
		$mail_event = $this->createMailEventOnForm($this->module, [
			'name' => 'TestMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
		]);

		$this->deleteMailEventOnDetail($mail_event);

		$this->seePageIs('/my-bitrix/'.$this->module->id.$this->path);
		$this->dontSee('TestMail');
	}

	/** @test */
	function you_cannot_delete_anothers_mail_event(){
		$mail_event = $this->createMailEventOnForm($this->module, [
			'name' => 'TestMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
		]);

		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();
		$mail_event2 = $this->createMailEventOnForm($module2, [
			'name' => 'TestHackMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
		]);
		$module2->deleteFolder();

		// удаляем через гет, потому что такой ссылки нет
		$this->visit('/my-bitrix/'.$module2->id.$this->path.'/'.$mail_event->id.'/delete');
		$this->seePageIs('/personal');

		// тут вероятен случай, что событие всё-таки удалиться, но в этих тестах я абстрагируюсь от бд
	}

	/** @test */
	function it_can_delete_var(){
		$mail_event = $this->createMailEventOnForm($this->module, [
			'name' => 'TestMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
		]);

		$var = BitrixMailEventsVar::where('code', 'trololo')->where('mail_event_id', $mail_event->id)->first();
		$this->click('delete-var-'.$var->id);

		$this->dontSee('trololo - Ololo');
	}

	/** @test */
	function you_cannot_delete_anothers_event_var(){
		$mail_event = $this->createMailEventOnForm($this->module, [
			'name' => 'TestMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
		]);

		$var = BitrixMailEventsVar::where('code', 'trololo')->where('mail_event_id', $mail_event->id)->first();

		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();
		$mail_event2 = $this->createMailEventOnForm($module2, [
			'name' => 'TestHackMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
		]);
		$module2->deleteFolder();

		// удаляем через гет, потому что такой ссылки нет
		$this->visit('/my-bitrix/'.$module2->id.$this->path.'/'.$mail_event2->id.'/vars/'.$var->id.'/delete');
		$this->seePageIs('/personal');
	}

	/** @test */
	function it_returns_mail_event_template_data_on_detail_page(){
		$mail_event = $this->createMailEventOnForm($this->module, [
			'name' => 'TestMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
		]);
		$template = $this->createMailEventTemplateOnForm($this->module, $mail_event, [
			'name'        => 'TestTemplate',
			'from'        => 'me',
			'to'          => '#YOU#',
			'copy'        => '#HIM#',
			'hidden_copy' => '#FSB#',
			'reply_to'    => 'me',
			'in_reply_to' => 'In?',
			'theme'       => 'Hi',
			'body'        => 'Ololo',
		]);

		$this->seePageIs('/my-bitrix/'.$this->module->id.$this->path.'/'.$mail_event->id.'/templates/'.$template->id);
		$this->seeInField('name', 'TestTemplate');
		$this->seeInField('from', 'me');
		$this->seeInField('to', '#YOU#');
		$this->seeInField('copy', '#HIM#');
		$this->seeInField('hidden_copy', '#FSB#');
		$this->seeInField('reply_to', 'me');
		$this->seeInField('in_reply_to', 'In?');
		$this->seeInField('theme', 'Hi');
		$this->seeInField('body', 'Ololo');
	}

	/** @test */
	function you_cannot_see_mail_event_template_page_of_anothers_module(){
		$mail_event = $this->createMailEventOnForm($this->module, [
			'name' => 'TestMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
		]);
		$template = $this->createMailEventTemplateOnForm($this->module, $mail_event, [
			'name'        => 'TestTemplate',
			'from'        => 'me',
			'to'          => '#YOU#',
			'copy'        => '#HIM#',
			'hidden_copy' => '#FSB#',
			'reply_to'    => 'me',
			'in_reply_to' => 'In?',
			'theme'       => 'Hi',
			'body'        => 'Ololo',
		]);

		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();
		$mail_event2 = $this->createMailEventOnForm($module2, [
			'name' => 'TestHackMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
		]);
		$module2->deleteFolder();

		$this->visit('/my-bitrix/'.$module2->id.$this->path.'/'.$mail_event2->id.'/templates/'.$template->id);
		$this->seePageIs('personal');
	}

	/** @test */
	function it_can_delete_mail_event_template(){
		$mail_event = $this->createMailEventOnForm($this->module, [
			'name' => 'TestMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
		]);
		$template = $this->createMailEventTemplateOnForm($this->module, $mail_event, [
			'name'        => 'TestTemplate',
			'from'        => 'me',
			'to'          => '#YOU#',
			'copy'        => '#HIM#',
			'hidden_copy' => '#FSB#',
			'reply_to'    => 'me',
			'in_reply_to' => 'In?',
			'theme'       => 'Hi',
			'body'        => 'Ololo',
		]);

		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/'.$mail_event->id);
		$this->see('TestTemplate');
		$this->click('delete-template-'.$template->id);
		$this->dontSee('TestTemplate');
	}

	/** @test */
	function you_cannot_delete_anothers_event_template(){
		$mail_event = $this->createMailEventOnForm($this->module, [
			'name' => 'TestMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
		]);
		$template = $this->createMailEventTemplateOnForm($this->module, $mail_event, [
			'name'        => 'TestTemplate',
			'from'        => 'me',
			'to'          => '#YOU#',
			'copy'        => '#HIM#',
			'hidden_copy' => '#FSB#',
			'reply_to'    => 'me',
			'in_reply_to' => 'In?',
			'theme'       => 'Hi',
			'body'        => 'Ololo',
		]);

		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();
		$mail_event2 = $this->createMailEventOnForm($module2, [
			'name' => 'TestHackMail',
			'code' => 'TEST_MAIL',
			'sort' => '1808',
			'var0' => ['name' => 'Ololo', 'code' => 'trololo']
		]);
		$module2->deleteFolder();

		$this->visit('/my-bitrix/'.$module2->id.$this->path.'/'.$mail_event2->id.'/templates/'.$template->id.'/delete');
		$this->seePageIs('personal');
	}
}

?>