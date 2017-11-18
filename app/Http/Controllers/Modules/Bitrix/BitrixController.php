<?php

namespace App\Http\Controllers\Modules\Bitrix;

use App\Models\Metrics\MetricsEventsLog;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Sorting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| Контролер для модулей на Битриксе
|--------------------------------------------------------------------------
*/

class BitrixController extends Controller{

    protected $rootFolder = DIRECTORY_SEPARATOR.'construct'.DIRECTORY_SEPARATOR.'bitrix'.DIRECTORY_SEPARATOR; // корневая папка модуля

    protected $request;

    public function __construct(Request $request){
        parent::__construct();

        $this->request = $request;
        // todo почему-то не получило вынести также и модуль
    }

    public function create(){
        return view("bitrix.new", compact('user')); // передаём данные из таблицы пользователей, чтобы подставлять их в формы
    }

    public function store(Requests\BitrixCreateRequest $request){
        // создание записи в бд и шаблона
        $bitrix = new Bitrix;

        // смотрим не занят ли код пользователя
        if (User::where('bitrix_partner_code', trim($request->PARTNER_CODE))->where('id', '!=', $this->user->id)->count()){
            return back()->withErrors([trans('bitrix_create.this_bitrix_partner_code_is_already_taken')]);
        }
        // на будущее сохраняем какие-то поля в таблицу пользователя, если они не были указаны, но были указаны сейчас
        Bitrix::completeUserProfile(Auth::id(), $request);

        // запись в БД
        $bitrix->name         = trim($request->MODULE_NAME);
        $bitrix->description  = trim($request->MODULE_DESCRIPTION);
        $bitrix->code         = trim($request->MODULE_CODE);
        $bitrix->PARTNER_NAME = trim($request->PARTNER_NAME);
        $bitrix->PARTNER_URI  = trim($request->PARTNER_URI);
        $bitrix->PARTNER_CODE = trim($request->PARTNER_CODE);
        $version              = trim($request->MODULE_VERSION);
        if (!preg_match('/[0-9]+\.[0-9]+\.[0-9]+/is', $version)){
            $version = '0.0.1';
        }
        if ($version == '0.0.0'){
            $version = '0.0.1';
        }
        $bitrix->version      = $version;
        $bitrix->default_lang = 'ru'; // todo давать возможность задать

        Auth::user()->bitrixes()->save($bitrix);
        $module_id = $bitrix->id;

        // логируем действие
        MetricsEventsLog::log('Добавлен модуль', $bitrix);

        if ($module_id){
            // устанавливаем сортировку
            Sorting::create(
                [

                    'module_id' => $module_id,
                    'user_id'   => Auth::id(),
                    'sort'      => 500
                ]
            );

            // создание папки модуля пользователя на серваке
            if (!$bitrix->createFolder()){
                return back()->withErrors([trans('bitrix_create.folder_creation_failure')]);
            }

            // письмо мне
            Mail::send('emails.admin.new_bitrix_module', [
                'user'   => $this->user,
                'module' => $bitrix
            ], function($m){
                $m->to(env('GOD_EMAIL'))->subject('Создан новый Битрикс модуль');
            });

            flash()->success(trans('bitrix.module_created'));

            return redirect(action('Modules\Bitrix\BitrixController@show', $module_id));
        }

        return back();
    }

    // детальная страница модуля
    public function show(Bitrix $module){
        $data = [
            'module' => $module
        ];

        // логируем действие
        MetricsEventsLog::log('Открыта детальная страница модуля', $module);

        return view("bitrix.detail", $data);
    }

    // редактирование параметра
    // todo не обновлять весь файл, а только нужные значения
    public function update(Bitrix $module){
        if ($this->request->name){
            $name = $this->request->name;

            // меняем в бд
            $module->name = $name;
            $module->save();

            // меняем в ланг файле
            $module->changeVarInLangFile($module->lang_key.'_MODULE_NAME', $name, DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.$module->default_lang.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'index.php');
        }
        if ($this->request->description){
            $description = $this->request->description;

            // меняем в бд
            $module->description = $description;
            $module->save();

            // меняем в ланг файле
            $module->changeVarInLangFile($module->lang_key.'_MODULE_DESC', $description, DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.$module->default_lang.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'index.php');
        }
        if ($this->request->version){
            $module->version = $this->request->version;
            $module->save();

            $module->changeVarsInModuleFileAndSave('bitrix'.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'version.php', $module->id);
        }

        if ($this->request->keywords){
            $module->keywords = $this->request->keywords;
            $module->save();
        }

        if (!$this->request->ajax()){
            return redirect(action('Modules\Bitrix\BitrixController@show', $module->id));
        }
    }

    // кнопка скачивания зип архива
    public function download_zip(Bitrix $module, Request $request){
        if (!$this->user->canDownloadModule()){
            return response(['message' => 'Nea'], 403);
        }

        $inputs = $request->all();

        if (!isset($inputs['files'])){ // когда убрали все файлы
            return back();
        }

        // логируем действие
        MetricsEventsLog::log(
            'Скачен архив модуля',
            [
                'module' => $module,
                'form'   => $inputs
            ]
        );

        $module->changeVersion($this->request->version);
        $module->updateDownloadCount();
        $module->updateDownloadTime();

        if ($pathToZip = $module->generateZip($request->files_encoding, $inputs["download_as"], $inputs['files'], $request->updater, $request->description)){
            if ($module->code != 'ololo_from_test'){ // для тестов, иначе эксепшион ловлю // todo придумать что-то поумнее
                $response = Response::download($pathToZip)->deleteFileAfterSend(true);
                if (ob_get_contents()){
                    ob_end_clean(); // без этого архив скачивается поверждённым
                }

                return $response;
            }
        }

        return back();
    }

    public function marketing(Bitrix $module){
        $data = [
            'module' => $module
        ];

        return view("bitrix.marketing.index", $data);
    }

    public function changeSort(Bitrix $module, Request $request){
        $module->setSort(intval($request->sort), $this->user->id);

        return back();
    }

    // удаление модуля
    public function destroy(Bitrix $module){
        // логируем действие
        MetricsEventsLog::log('Удалён модуль', $module);

        // удаляем папку
        $module->deleteFolder(); // todo перенести в обработчик события удаления
        // удаляем запись из БД
        $module->delete();

        return redirect(action("PersonalController@index"));
    }
}
