<?php

use App\Models\FunctionalSuggestion;
use Illuminate\Foundation\Testing\DatabaseTransactions;

// todo здесь три теста перестали работать
class FunctionalSuggestionTest extends TestCase{

	protected $path = 'functional_suggestions';
	protected $adminUserGroup = 1;

	use DatabaseTransactions;

	/** @test */
	function unauthorized_can_add_suggestion(){
		$this->visit($this->path);

		$this->submitForm('create', [
			'name'        => 'Нечто суперкрутое',
			'description' => 'Это очень нужный функционал',
		]);

		$this->see('Нечто суперкрутое');
		$this->see('Это очень нужный функционал');
		$this->see('Голосов: 0');
	}

	/** @test */
	function authorized_can_add_suggestion(){
		$this->signIn();

		$this->visit($this->path);

		$this->submitForm('create', [
			'name'        => 'Нечто суперкрутое',
			'description' => 'Это очень нужный функционал',
		]);

		$this->see('Нечто суперкрутое');
		$this->see('Это очень нужный функционал');
		$this->see('Голосов: 1'); // авторизованный сразу голосует за своё
	}

	/** @test */
	function authorized_can_vote_after_authorised(){
		$this->signIn();

		$this->visit($this->path);

		$this->submitForm('create', [
			'name'        => 'Нечто суперкрутое',
			'description' => 'Это очень нужный функционал',
		]);

		$suggestion = FunctionalSuggestion::first();

		// так как при создании мы уже лайкаем, лайкать должен второй
		$this->signIn();
		$this->click('upvote'.$suggestion->id);

		$this->see('Голосов: 2');
	}

	/** @test */
	function authorized_can_vote_after_unauthorised(){
		$this->visit($this->path);

		$this->submitForm('create', [
			'name'        => 'Нечто суперкрутое',
			'description' => 'Это очень нужный функционал',
		]);

		$suggestion = FunctionalSuggestion::first();

		$this->signIn();
		$this->visit($this->path);
		$this->click('upvote'.$suggestion->id);

		$this->see('Голосов: 1');
	}

	/** @test */
	function authorized_cannot_add_suggestion_duplicate(){
		$this->signIn();

		$this->visit($this->path);

		$this->submitForm('create', [
			'name'        => 'Нечто суперкрутое',
			'description' => 'Это очень нужный функционал',
		]);

		$this->submitForm('create', [
			'name'        => 'Нечто суперкрутое',
			'description' => 'Но с другим описанием',
		]);

		$this->see('Такое предложение уже существует');
	}

	/** @test */
	function unauthorized_cannot_vote(){
		$this->signIn();

		$this->visit($this->path);

		$this->submitForm('create', [
			'name'        => 'Нечто суперкрутое',
			'description' => 'Это очень нужный функционал',
		]);

		$suggestion = FunctionalSuggestion::first();

		$this->logOut();
		$this->visit($this->path);

		$this->dontSee('upvote'.$suggestion->id); // в принципе не видит кнопку

		$this->visit('/functional_suggestions/'.$suggestion->id.'/upvote'); // хитрый нашёл прямую ссылку
		$this->visit($this->path);
		$this->see('Голосов: 1'); // но голоса по итогу не прибавились
	}

	/** @test */
	function admin_can_delete_suggestion(){
		$this->visit($this->path);

		$this->submitForm('create', [
			'name'        => 'Нечто суперкрутое',
			'description' => 'Это очень нужный функционал',
		]);
		$this->see('Нечто суперкрутое');
		$this->see('Это очень нужный функционал');

		$suggestion = FunctionalSuggestion::first();

		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);
		$this->visit($this->path);
		$this->click('delete'.$suggestion->id);

		$this->dontSee('Нечто суперкрутое');
		$this->dontSee('Это очень нужный функционал');
	}

	/** @test */
	function not_admin_cannot_delete_suggestion(){
		$this->signIn();
		$this->visit($this->path);

		$this->submitForm('create', [
			'name'        => 'Нечто суперкрутое',
			'description' => 'Это очень нужный функционал',
		]);

		$suggestion = FunctionalSuggestion::first();

		$this->see('Нечто суперкрутое');
		$this->see('Это очень нужный функционал');
		$this->dontSee('delete'.$suggestion->id);

		$this->visit('/functional_suggestions/'.$suggestion->id.'/delete'); // здесь только по прямой ссылке, кнопки ведь нет
		$this->visit($this->path);

		$this->see('Нечто суперкрутое');
		$this->see('Это очень нужный функционал');
	}
}

?>