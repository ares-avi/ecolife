<?php

/**
 * Get file
 * 
 * @param integer $guid A file guid
 * 
 * @return object|boolean
 */
function el_get_file($guid) {
		$file       = new ElFile;
		$file->guid = $guid;
		$file       = $file->getFile();
		if($file) {
				return $file;
		}
		return false;
}