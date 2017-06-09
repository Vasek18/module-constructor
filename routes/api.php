<?php

Route::get('user', ['uses' => 'Api\ApiController@getUserInfo']);
Route::get('modules', ['uses' => 'Api\ApiController@getModulesList']);
Route::post('modules/{module}/import/iblock', ['uses' => 'Api\ApiController@importIblock']);