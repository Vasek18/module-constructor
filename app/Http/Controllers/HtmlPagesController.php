<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Mail;

class HtmlPagesController extends Controller{

	public function oplata(Request $request){
		return view("html_pages.oplata");
	}
}