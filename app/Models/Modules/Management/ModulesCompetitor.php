<?php

namespace App\Models\Modules\Management;

use Illuminate\Database\Eloquent\Model;
use App\Models\Modules\Management\ModulesCompetitorsUpdate;

class ModulesCompetitor extends Model{

    protected $table = 'modules_competitors';

    protected $fillable = [
        'module_id',
        'name',
        'link',
        'price',
        'sort',
        'picture_src',
        'comment',
    ];

    public $timestamps = false;

    public function getUpdatesFromParsing(){
        // получаем ссылку на обновление
        $link = $this->getLinkOfPageWithUpdates();
        if (!$link){
            return false;
        }
        // получаем страницу
        $page = iconv('windows-1251', 'utf-8', file_get_contents($this->link));
        if (!$page){
            return false;
        }

        // вытаскиваем из страницы инфу про обновления
        $updatesArr = $this->parseBitrixMarketplaceUpdatesPage($page);

        foreach ($updatesArr as $fields){
            ModulesCompetitorsUpdate::updateOrCreate(
                [
                    'module_id' => $this->id,
                    'version'   => $fields['version'],
                ],
                [
                    'module_id'   => $this->id,
                    'description' => $fields['description'],
                    'version'     => $fields['version'],
                    'date'        => $fields['date'],
                ]
            );
        }
    }

    public function parseBitrixMarketplaceUpdatesPage($html){
        $maxCount = 10; // забираем не все обновления со страницы

        $items = [];

        // обрезаем до нужной вкладки
        $html = substr($html, strpos($html, '<div class="tab-title tab-off">Что нового</div>'));

        // обрезаем до края таблицы
        $html = substr($html, 0, strpos($html, '</table>'));

        // разбиваем ячейки таблицы
        $tds = preg_split('/\<td[^\<]+\>/is', $html);
        unset($tds[0]); // тут шапка была

        $items = [];
        foreach ($tds as $c => $text){
            if ($c >= $maxCount * 2){
                break;
            }

            if ($c % 2 == 1){ // левая ячейка
                list($version, $date) = explode('</b>', $text);
                $items[$c]['version'] = trim(strip_tags($version));
                $items[$c]['date']    = str_replace([
                    '(',
                    ')'
                ], '', trim(strip_tags($date)));
            } else{ // правая ячейка
                $items[$c - 1]['description'] = trim(strip_tags($text));
            }
        }

        return $items;
    }

    // актуально только для Маркетплейса Битрикса
    public function getLinkOfPageWithUpdates(){
        if (!$this->link){
            return false;
        }

        $link = $this->link;

        // сейчас работаем только с Маркетплейсом Битрикса
        if (strpos($link, 'http://marketplace.1c-bitrix.ru' === false)){
            return false;
        }

        // обрезаем лишнее
        if (strpos($link, '#')){
            $link = substr($link, 0, strpos($link, '#'));
        }
        if (strpos($link, '?')){
            $link = substr($link, 0, strpos($link, '?'));
        }

        // обновления перечислены на этой странице
        $link .= '#tab-log-link';

        return $link;
    }

    // связи с другими модулями
    public function module(){
        return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
    }

    public function updates(){
        return $this->hasMany('App\Models\Modules\Management\ModulesCompetitorsUpdate', 'module_id');
    }
}
