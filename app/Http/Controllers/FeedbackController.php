<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Mail;

class FeedbackController extends Controller{
	public function sendILackSmthForm(Request $request){
		Mail::send('emails.ilack', ['page' => $request->page, 'email' => $request->email, 'text' => $request->text], function ($m){
			$m->to(env('GOD_EMAIL'))->subject('Кому-то то-то не нравится');
		});

		return back();
	}

	public function sendBugReportForm(Request $request){
		Mail::send('emails.bug_report', ['page' => $request->page, 'text' => $request->text], function ($m){
			$m->to(env('GOD_EMAIL'))->subject('Сообщение об ошибке');
		});

		return back();
	}
}
