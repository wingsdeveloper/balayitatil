<?php
namespace App\Traits;
use File;
trait FileTraits {

	public function folderCreate($path)
	{
		$exploded = explode('/', $path);
		$current = '';
		array_pop($exploded);
		// dd(sizeof($exploded));
		foreach($exploded as $key => $row):
			// if (sizeof($exploded )>= $key):break;endif;
			$current = $current . $row;

			// dd($current);
			if(!File::exists($current)):
				File::makeDirectory($current);
			endif;
			$current = $current . '/';
		endforeach;
		// dd($current);
		#buraya ait olan path olusturulmus olur
	}
	public function thumbFolderCreate()
	{
		$exploded = explode('/', $path . '/thumb');
		$current = '';
		array_pop($exploded);
		// dd(sizeof($exploded));
		foreach($exploded as $key => $row):
			// if (sizeof($exploded )>= $key):break;endif;
			$current = $current . $row;

			// dd($current);
			if(!File::exists($current)):
				File::makeDirectory($current);
			endif;
			$current = $current . '/';
		endforeach;
		// dd($current);
		#buraya ait olan path olusturulmus olur

	}

}