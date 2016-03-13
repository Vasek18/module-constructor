<?php
function upgradeVersionNumber($version){
	$versionArr = explode(".", $version);
	$lastIndex = count($versionArr)-1;
	$versionArr[$lastIndex]++;
	$version = implode(".", $versionArr);
	return $version;
}
?>