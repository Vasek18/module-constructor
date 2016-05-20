<?php

namespace App\Http\Controllers\Modules\Bitrix;

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use App\Http\Controllers\Traits\UserOwnModule;
use Illuminate\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| Контролер для создания модулей на Битриксе
|--------------------------------------------------------------------------
|
|
*/

class BitrixController extends Controller{
	protected $rootFolder = '/construct/bitrix/'; // корневая папка модуля

	use UserOwnModule;

	protected $request;

	public function __construct(Request $request){
		parent::__construct();
		$this->middleware('auth');

		$this->request = $request;
		// todo почему-то не получило вынести также и модуль
	}

	public function create(){
		return view("bitrix.new", compact('user')); // передаём данные из таблицы пользователей, чтобы подставлять их в формы
	}

	public function store(Requests\BitrixCreateRequest $request){
		// создание записи в бд и шаблона
		$id = Bitrix::store($request);
		if ($id){
			return redirect(action('Modules\Bitrix\BitrixController@show', $id));
		}else{
			return back();
		}
	}

	// детальная страница модуля
	public function show(Bitrix $module){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($this->request);
		}
		//dd($id);
		$data = [
			'module' => $module
		];

		//dd(Bitrix::where("id", $id)->get());
		return view("bitrix.detail", $data);
	}

	// редактирование параметра
	public function update(Bitrix $module){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($this->request);
		}
		if ($this->request->name){
			$module->name = $this->request->name;
			$module->save();

			$module->changeVarsInModuleFileAndSave('bitrix/lang/ru/install/index.php', $module->id);
		}
		if ($this->request->description){
			$module->description = $this->request->description;
			$module->save();

			$module->changeVarsInModuleFileAndSave('bitrix/lang/ru/install/index.php', $module->id);
		}
		if ($this->request->version){
			$module->version = $this->request->version;
			$module->save();

			$module->changeVarsInModuleFileAndSave('bitrix/install/version.php', $module->id);
		}

		if (!$this->request->ajax()){
			return redirect(action('Modules\Bitrix\BitrixController@show', $module->id));
		}
	}

	// кнопка скачивания зип архива
	// todo нельзя скачать модуль, если он не оплачен
	// todo нельзя указать версию ниже нынешней
	// todo нельзя указать последнюю версию, если были произведены изменения
	public function download_zip(Bitrix $module){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($this->request);
		}

		//dd($this->request->version);

		if ($module->can_download){
			Bitrix::upgradeVersion($module->id, $this->request->version);
			Bitrix::updateDownloadCount($module->id);

			if ($pathToZip = $module->generateZip()){
				$response = Response::download($pathToZip)->deleteFileAfterSend(true);
				ob_end_clean(); // без этого архив скачивается поверждённым

				$this->user->makeBuy($module->priceForDownload);

				return $response;
			}
		}

		return back();
	}

	// удаление модуля
	// todo подтверждение удаления
	public function destroy(Bitrix $module){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($this->request);
		}
		// удаляем папку
		$module->deleteFolder();
		// удаляем запись из БД
		$module->delete();

		return redirect(action("PersonalController@index"));
	}
}
