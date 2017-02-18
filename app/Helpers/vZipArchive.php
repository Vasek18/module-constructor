<?php

namespace App\Helpers;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class vZipArchive{
	public static function createZipArchiveFromFolder($archiveName, $folder, $rootFolder = ''){
		$zip = new ZipArchive();
		$zip->open($archiveName, ZipArchive::CREATE | ZipArchive::OVERWRITE);

		if ($rootFolder){
			$zip->addEmptyDir($rootFolder);
		}

		$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($folder),
			RecursiveIteratorIterator::LEAVES_ONLY
		);
		foreach ($files as $name => $file){
			if (!$file->isDir()){
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen($folder) + 1);
				if ($rootFolder){
					$relativePath = $rootFolder.DIRECTORY_SEPARATOR.$relativePath;
				}
				$zip->addFile($filePath, $relativePath);
			}
		}
		if ($zip->close()){
			return true;
		}

		return false;
	}
}