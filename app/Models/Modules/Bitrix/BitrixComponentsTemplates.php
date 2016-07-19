<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Chumper\Zipper\Zipper;

class BitrixComponentsTemplates extends Model{
	protected $table = 'bitrix_components_templates';
	protected $fillable = ['component_id', 'code', 'name'];
	public $timestamps = false;

	public function extractUploadedZip($archive){
		$fileName = time().$archive->getClientOriginalName();
		$archive->move('user_upload/', $fileName);

		$zipper = new Zipper;
		$zipper->make('user_upload/'.$fileName);
		if ($zipper->contains('template.php')){
			$this->createFolder();
			$zipper->extractTo($this->component->getFolder(true).'/templates/'.$this->code);
		}else{
			$zipper->extractTo($this->component->getFolder(true).'/templates/');
		}
		$zipper->close();

		unlink('user_upload/'.$fileName);
	}

	public function createFolder(){
		$this->component()->first()->module()->first()->disk()->makeDirectory($this->component->getFolder().'/templates/'.$this->code);
	}

	public function getFolder(){
		$component_folder = $this->component()->first()->getFolder();

		return $component_folder.'\templates\\'.$this->code;
	}

	public function disk(){
		return $this->component->module->disk();
	}

	public function getTemplatePhpAttribute(){
		$code = "";
		$path = $this->getFolder().'\template.php';
		if ($this->disk()->exists($path)){
			$code = $this->disk()->get($path);
		}

		return $code;
	}

	public function getStyleCssAttribute(){
		$code = "";
		$path = $this->getFolder().'\style.css';
		if ($this->disk()->exists($path)){
			$code = $this->disk()->get($path);
		}

		return $code;
	}

	public function getScriptJsAttribute(){
		$code = "";
		$path = $this->getFolder().'\script.js';
		if ($this->disk()->exists($path)){
			$code = $this->disk()->get($path);
		}

		return $code;
	}

	public function getResultModifierPhpAttribute(){
		$code = "";
		$path = $this->getFolder().'\result_modifier.php';
		if ($this->disk()->exists($path)){
			$code = $this->disk()->get($path);
		}

		return $code;
	}

	public function getComponentEpilogPhpAttribute(){
		$code = "";
		$path = $this->getFolder().'\component_epilog.php';
		if ($this->disk()->exists($path)){
			$code = $this->disk()->get($path);
		}

		return $code;
	}

	public function component(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixComponent');
	}
}
