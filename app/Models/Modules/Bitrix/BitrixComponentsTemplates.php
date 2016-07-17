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

	public function getTemplatePhpAttribute(){
		$code = $this->component->module->disk()->get($this->getFolder().'\template.php');

		return $code;
	}

	public function getStyleCssAttribute(){
		$code = $this->component->module->disk()->get($this->getFolder().'\style.css');

		return $code;
	}

	public function getScriptJsAttribute(){
		$code = $this->component->module->disk()->get($this->getFolder().'\script.js');

		return $code;
	}

	public function getResultModifierPhpAttribute(){
		$code = $this->component->module->disk()->get($this->getFolder().'\result_modifier.php');

		return $code;
	}

	public function getComponentEpilogPhpAttribute(){
		$code = $this->component->module->disk()->get($this->getFolder().'\component_epilog.php');

		return $code;
	}

	public function component(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixComponent');
	}
}
