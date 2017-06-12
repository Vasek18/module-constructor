<?php

Route::get('user', ['uses' => 'Api\ApiController@getUserInfo']);
Route::get('modules', ['uses' => 'Api\ApiController@getModulesList']);
Route::post('modules/{module}/import/iblock', ['uses' => 'Api\ApiController@importIblock']);
Route::post('modules/{module}/import/component', ['uses' => 'Api\ApiController@importComponent']);
Route::post('modules/{module}/import/adminpage', ['uses' => 'Api\ApiController@importAdminpage']);
Route::post('modules/{module}/import/otherfile', ['uses' => 'Api\ApiController@importOtherfile']);