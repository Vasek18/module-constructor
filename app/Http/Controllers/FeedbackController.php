<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use App\Models\User\UserReport;
use App\Models\User\UserReportType;

class FeedbackController extends Controller{
	public function sendILackSmthForm(Request $request){
		// простейшая защита от спама
		if ($request->hint){
			return back();
		}

		if (trim($request->text)){
			$mail = Mail::send('emails.ilack', ['page' => $request->page, 'email' => $request->email, 'text' => $request->text], function ($m){
				$m->to(env('GOD_EMAIL'))->subject('Кому-то то-то не нравится');
			});

			if ($mail){
				flash()->success(trans('app.email_was_sent'));
			}
		}

		return back();
	}

	public function sendBugReportForm(Request $request){
		// простейшая защита от спама
		if ($request->hint){
			return back();
		}

		// сохраняем заявку
		UserReport::create([
			'user_id'     => $this->user ? $this->user->id : null,
			'user_email'  => $this->user ? $this->user->email : null,
			'description' => $request->text,
			'page_link'   => $request->page,
			'type_id'     => UserReportType::where('code', 'error')->first()->id,
		]);

		// отправляем сообщение
		$mail = Mail::send('emails.bug_report', ['page' => $request->page, 'text' => $request->text], function ($m){
			$m->to(env('GOD_EMAIL'))->subject('Сообщение об ошибке');
		});

		if ($mail){
			flash()->success(trans('app.email_was_sent'));
		}

		return back();
	}
}
