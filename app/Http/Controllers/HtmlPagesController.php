<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Mail;

class HtmlPagesController extends Controller{

	public function oplata(Request $request){
		return view("html_pages.oplata");
	}

	public function does_it_charge(Request $request){
		return view("html_pages.does_it_charge");
	}

	public function contacts(Request $request){
		return view("html_pages.contacts");
	}

	public function requisites(Request $request){
		return view("html_pages.requisites");
	}

	public function personal_info_agreement(){
		return view("html_pages.personal_info_agreement");
	}

	public function politika_konfidencialnosti(){
		return view("html_pages.politika_konfidencialnosti");
	}
}