<?php
function upgradeVersionNumber($version){
	$versionArr = explode(".", $version);
	$lastIndex = count($versionArr) - 1;
	$versionArr[$lastIndex]++;
	$version = implode(".", $versionArr);

	return $version;
}

// todo это должно быть по идее в пространстве имён Битрикса
function extractLangVal($val, $langfile){
	preg_match('/GetMessage\([\"\']+([^\"\']+)/is', $val, $matches);
	if (isset($matches[1])){
		$vArrParse = new App\vArrParse;
		$langVals = $vArrParse->parseFromFile($langfile, '$MESS');
		//dd($langVals);

		if(isset($langVals[$matches[1]])){
			//dd($langVals[$matches[1]]);
			return $langVals[$matches[1]];
		}
		else{
			return '';
		}
	}

	return $val;
}

?>