<?php
namespace App\Repo\ImageProcess\src;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Villa;
use DB;

class MultiProcess implements ShouldQueue{

	public function getVillaImages($imageHandler)
	{
		$villas = Villa::with('photos')->get();

		foreach($villas as $key => $row):
			// buradaki yuklu olan buturn resimlerin getirilmesi ile ilgilenecektir
			try {
				$name = $row->list_image_name;
				$image = file_get_contents($this->server_ip . '/' . $row->list_image_name );
			} catch (\Exception $e) {

			}
			if(!empty($image)):
				$img = $imageHandler::make($image);
				$img->save($name, 80);
			endif;

			try {
				$image = file_get_contents($this->server_ip . '/' . $row->list_image_thumb );
				$name = $row->list_image_thumb;
			} catch (\Exception $e) {
				
			}
			if(!empty($image)):
				$img = $imageHandler::make($image);
				$img->save($name, 80);
			endif;
			try {
				$image = file_get_contents($this->server_ip . '/' . $row->banner_image );
				$name = $row->banner_image;
			} catch (\Exception $e) {
				
			}
			if(!empty($image)):
				$img = $imageHandler::make($image);
				$img->save($name, 80);
			endif;
			try {
				$image = file_get_contents($this->server_ip . '/' . $row->banner_image_thumb );
				$name = $row->banner_image_thumb;
			} catch (\Exception $e) {
				
			}
			if(!empty($image)):
				$img = $imageHandler::make($image);
				$img->save($name, 80);
			endif;
			try {
				$image = file_get_contents($this->server_ip . '/' . $row->banner_image_mobile );
				$name = $row->banner_image_mobile;
			} catch (\Exception $e) {
				
			}
			if(!empty($image)):
				$img = $imageHandler::make($image);
				$img->save($name, 80);
			endif;
			try {
				$image = file_get_contents($this->server_ip . '/' . $row->banner_image_mobile_thumb );
				$name = $row->banner_image_mobile_thumb;
			} catch (\Exception $e) {
				
			}
			if(!empty($image)):
				$img = $imageHandler::make($image);
				$img->save($name, 80);
			endif;
		endforeach;
	}
	
}