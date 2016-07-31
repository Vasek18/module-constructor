<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Mail;

class FeedbackController extends Controller{
	public $emailto = 'aristov-92@mail.ru';

	public function sendILackSmthForm(Request $request){
		Mail::send('emails.ilack', ['page' => $request->page, 'email' => $request->email, 'text' => $request->text], function ($m){
			$m->to($this->emailto)->subject('Кому-то то-то не нравится');
		});

		return back();
	}
}
