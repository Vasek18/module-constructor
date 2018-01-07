<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group bitrix_files */
class BitrixSiteTemplatesFormFilesTest extends BitrixTestCase{

    use DatabaseTransactions;

    // todo проверка создания шаблона (записывается название, описание, сортировка)
    // todo проверка, что файлы (кроме description) не перезаписываются
    // todo проверка, что если обязательного файла нет, то он создаётся
    // todo проверка ситуации, когда пользователь грузит файлы, а не папку с шаблоном (в интерфейсе)
    // todo проверка парсинга тем из папки шаблона
    // test удаления шаблона
}