<?php
namespace App\Http;

class Flash{
	public function create($title, $message, $level, $key = 'flash_message'){
		session()->flash($key, [
			'title'   => $title,
			'message' => $message,
			'level'   => $level
		]);
	}

	public function info($title, $message = ''){
		$this->create($title, $message, 'info');
	}

	public function error($title, $message = ''){
		$this->create($title, $message, 'error');
	}

	public function success($title, $message = ''){
		$this->create($title, $message, 'success');
	}

	public function overlay($title, $message = '', $level = 'success'){
		$this->create($title, $message, $level, 'flash_message_overlay');
	}
}
