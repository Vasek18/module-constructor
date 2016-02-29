<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use App\Models\Modules\Bitrix\Bitrix;

trait UserOwnModule{
	protected function userCreatedModule($id){
		return Bitrix::where([
			'id' => $id,
			'user_id' => $this->user->id
		])->exists();
	}

	protected function unauthorized(Request $request){
		if ($request->ajax()){
			return response(['message' => 'Nea'], 403);
		}

		return redirect('/');
	}
}
?>