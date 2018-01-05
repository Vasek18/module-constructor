<?php

use App\Helpers\vArrParse;
use App\Helpers\vFuncParse;
use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TestCase extends Illuminate\Foundation\Testing\TestCase{

    public $module;
    protected $standartModuleName = 'Ololo';
    protected $standartModuleDescription = 'Ololo trololo';
    protected $standartModuleCode = 'ololo_from_test';
    protected $standartModuleVersion = '0.0.1';
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://constructor.local';
    protected $user;

    public function tearDown(){
        // иначе ошибка количества подключений
        $this->beforeApplicationDestroyed(function(){
            DB::disconnect();
        });

        parent::tearDown();
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication(){
        ini_set('memory_limit', '256M');

        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function signIn($user = null, $params = []){
        if (!isset($params["paid_days"])){
            $params["paid_days"] = setting('demo_days', 2);
        }
        if (!$user){
            $user = factory(App\Models\User::class)->create($params);
        }
        $this->user = $user;

        $this->actingAs($user);

        return $this;
    }

    public function logOut(){
        $this->post(route('logout'));

        return $this;
    }

    public function setLang($lang = 'ru'){
        // $uri = '';
        // if ($lang == 'en'){
        // 	$uri = str_replace('http://', 'http://en.', $this->currentUri);
        // }
        // if ($lang == 'ru'){
        // 	$uri = str_replace('http://en.', 'http://', $this->currentUri);
        // }
        // $this->visit($uri);
        Illuminate\Support\Facades\Session::put('lang', $lang);
    }

    public function payDays($days){
        // почему-то оба работают в разных местах

        $user            = User::find(Auth::id());
        $user->paid_days = intval($days);
        $user->save();

        $this->user->paid_days = intval($days);
    }

    // главная форма Битрикса
    function fillNewBitrixForm($params = Array()){
        Mail::shouldReceive('send')->zeroOrMoreTimes(); // против почты

        if (!isset($params['PARTNER_NAME'])){
            $params['PARTNER_NAME'] = $this->user->bitrix_company_name;
        }
        if (!isset($params['PARTNER_URI'])){
            $params['PARTNER_URI'] = $this->user->site;
        }
        if (!isset($params['PARTNER_CODE'])){
            $params['PARTNER_CODE'] = $this->user->bitrix_partner_code;
        }
        if (!isset($params['MODULE_NAME'])){
            $params['MODULE_NAME'] = $this->standartModuleName;
        }
        if (!isset($params['MODULE_DESCRIPTION'])){
            $params['MODULE_DESCRIPTION'] = $this->standartModuleDescription;
        }
        if (!isset($params['MODULE_CODE'])){
            $params['MODULE_CODE'] = $this->standartModuleCode;
        }
        if (!isset($params['MODULE_VERSION'])){
            $params['MODULE_VERSION'] = $this->standartModuleVersion;
        }

        $this->visit('/my-bitrix/create');

        $this->type($params['PARTNER_NAME'], 'PARTNER_NAME');
        $this->type($params['PARTNER_URI'], 'PARTNER_URI');
        $this->type($params['PARTNER_CODE'], 'PARTNER_CODE');
        $this->type($params['MODULE_NAME'], 'MODULE_NAME');
        $this->type($params['MODULE_DESCRIPTION'], 'MODULE_DESCRIPTION');
        $this->type($params['MODULE_CODE'], 'MODULE_CODE');
        $this->type($params['MODULE_VERSION'], 'MODULE_VERSION');
        $this->press('module_create');

        if ($params['PARTNER_CODE'] && $params['MODULE_CODE']){
            return Bitrix::where('PARTNER_CODE', $params['PARTNER_CODE'])->where('code', $params['MODULE_CODE'])->first();
        }
    }

    // форма создания типового сайта Битрикса
    function fillNewBitrixSiteForm($params = Array()){
        Mail::shouldReceive('send')->zeroOrMoreTimes(); // против почты

        if (!isset($params['PARTNER_NAME'])){
            $params['PARTNER_NAME'] = $this->user->bitrix_company_name;
        }
        if (!isset($params['PARTNER_URI'])){
            $params['PARTNER_URI'] = $this->user->site;
        }
        if (!isset($params['PARTNER_CODE'])){
            $params['PARTNER_CODE'] = $this->user->bitrix_partner_code;
        }
        if (!isset($params['MODULE_NAME'])){
            $params['MODULE_NAME'] = $this->standartModuleName;
        }
        if (!isset($params['MODULE_DESCRIPTION'])){
            $params['MODULE_DESCRIPTION'] = $this->standartModuleDescription;
        }
        if (!isset($params['MODULE_CODE'])){
            $params['MODULE_CODE'] = $this->standartModuleCode;
        }
        if (!isset($params['MODULE_VERSION'])){
            $params['MODULE_VERSION'] = $this->standartModuleVersion;
        }

        $this->visit('/my-bitrix/create');

        $this->type($params['PARTNER_NAME'], 'PARTNER_NAME');
        $this->type($params['PARTNER_URI'], 'PARTNER_URI');
        $this->type($params['PARTNER_CODE'], 'PARTNER_CODE');
        $this->type($params['MODULE_NAME'], 'MODULE_NAME');
        $this->type($params['MODULE_DESCRIPTION'], 'MODULE_DESCRIPTION');
        $this->type($params['MODULE_CODE'], 'MODULE_CODE');
        $this->type($params['MODULE_VERSION'], 'MODULE_VERSION');
        $this->press('site_create');

        if ($params['PARTNER_CODE'] && $params['MODULE_CODE']){
            return Bitrix::where('PARTNER_CODE', $params['PARTNER_CODE'])->where('code', $params['MODULE_CODE'])->first();
        }
    }

    public function create_approved_event(){
        $module_id = 1;

        $id = DB::table('bitrix_core_events')->insertGetId([
            'module_id' => $module_id,
            'code'      => 'OnEpilog',
            'approved'  => true,
        ]);

        return DB::table('bitrix_core_events')->where('id', $id)->first();
    }

    public function create_approved_module(){
        $id = DB::table('bitrix_core_modules')->insertGetId([
            'code'     => 'goodModule',
            'approved' => true,
        ]);

        return DB::table('bitrix_core_modules')->where('id', $id)->first();
    }

    public function create_unapproved_event(){
        $module_id = 1;

        $id = DB::table('bitrix_core_events')->insertGetId([
            'module_id' => $module_id,
            'code'      => 'OnProlog',
            'approved'  => false,
        ]);

        return DB::table('bitrix_core_events')->where('id', $id)->first();
    }

    public function create_unapproved_module(){
        $id = DB::table('bitrix_core_modules')->insertGetId([
            'code'     => 'testModule',
            'approved' => false,
        ]);

        return DB::table('bitrix_core_modules')->where('id', $id)->first();
    }

    public function create_marked_event(){
        $module_id = 1;

        $id = DB::table('bitrix_core_events')->insertGetId([
            'module_id' => $module_id,
            'code'      => 'OnProlog',
            'approved'  => true,
            'is_bad'    => true,
        ]);

        return DB::table('bitrix_core_events')->where('id', $id)->first();
    }

    public function sendBugReport($inputs = []){
        Mail::shouldReceive('send')->once();

        if (!isset($inputs['text'])){
            $inputs['text'] = 'I found a bug';
        }

        $this->submitForm('send_bug_report', $inputs);

        return true;
    }

    // берёт сразу все инфоблоки и записывает их в массивы, то есть возвращается не массив установки, а массив массивов установки
    // также записывает туда и массивы создания свойств
    public function getIblockCreationFuncCallParamsArray($module){
        $answer                     = [];
        $installationFileContent    = file_get_contents($module->getFolder(true).'/install/index.php');
        $gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
        // dd($installationFileContent);

        preg_match_all('/(\$this\-\>createIblock\([^\;]+\);)/is', $gottenInstallationFuncCode, $matches);

        foreach ($matches[1] as $gottenInstallationFuncCodePart){
            $answer[] = vArrParse::parseFromText($gottenInstallationFuncCodePart);
        }

        return $answer;
    }

    public function getLangFileArray($module, $lang = 'ru'){
        $optionsFileContent = $this->bitrixModulesDisk()->get($module->module_folder.'/lang/'.$lang.'/install/index.php');
        $optionsArr         = vArrParse::parseFromText($optionsFileContent, 'MESS');

        return $optionsArr;
    }

    public function bitrixModulesDisk(){
        return Storage::disk('user_modules_bitrix');
    }

    // берёт сразу все свойства и записывает их в массивы, то есть возвращается не массив установки, а массив массивов установки
    function getIblockPropsCreationFuncCallParamsArray($module){
        $answer                     = [];
        $installationFileContent    = file_get_contents($module->getFolder(true).'/install/index.php');
        $gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
        // dd($installationFileContent);

        preg_match_all('/\$this\-\>createIblockProp\(([^\;]+)\);/is', $gottenInstallationFuncCode, $matches);
        // dd($matches[1]);
        foreach ($matches[1] as $gottenInstallationFuncCodePart){
            $answer[] = vArrParse::parseFromText($gottenInstallationFuncCodePart);
        }

        return $answer;
    }

    function getIblockPropsValsCreationFuncCallParamsArray($module){
        $answer                     = [];
        $installationFileContent    = file_get_contents($module->getFolder(true).'/install/index.php');
        $gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
        // dd($installationFileContent);

        preg_match_all('/\$this\-\>createIblockPropVal\(([^\;]+)\);/is', $gottenInstallationFuncCode, $matches);
        // dd($matches[1]);
        foreach ($matches[1] as $gottenInstallationFuncCodePart){
            $answer[] = vArrParse::parseFromText($gottenInstallationFuncCodePart);
        }

        return $answer;
    }
}
