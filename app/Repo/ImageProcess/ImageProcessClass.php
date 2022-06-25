<?php

namespace App\Repo\ImageProcess;

use App\Villa;
use App\Repo\ImageProcess\src\MultiProcess;
use File, Image, DB;

use App\Helpers\Helper;

use App\Traits\FileTraits;
class ImageProcessClass {

	use FileTraits;

	protected $path = [];

	// ImageProcessClassta server ip si tutulmalidir
	protected $villaGalleryPath;

	public function __construct()
	{ return;

		$this->server_ip = config('app.server_ip');
		$this->server_ip = 'http://' . $this->server_ip;
		$this->imageHandler = new Image();
		$this->serverVillaGalleryPath = $this->server_ip . '/uploads/villa/gallery';
		$this->villaPhotoPath = 'villa';
		$this->watermark_path = $this->server_ip . '/' . 'watermarks/' . 15/*APP_WEBSITE_ID*/ . '/' . 'watermark.png';
	}

	public function getImageWatermarkedPath($image, $mobile = false)
    { return;

        #image path name olarak kontrol edilmelidir.
        if($mobile == true):
			try {
            $villaPhotoPath = $this->villaPhotoPath . '/' . $image->path . '/mobile/' . $image->name;
            if(!File::exists($villaPhotoPath)):
                return $this->getImageWatermarked($image->id, $mobile);
            else:

                return asset($villaPhotoPath);
            endif;
		} catch(\Exception $e) {
			return asset('');
		}
        else:
            try {
                $villaPhotoPath = $this->villaPhotoPath . '/' . $image->path . '/' . $image->name;
                if(!File::exists($villaPhotoPath)):
                    return $this->getImageWatermarked($image->id, $mobile);
                else:
                    return asset($villaPhotoPath);
                endif;

            } catch(\Exception $e) {
                return asset('');
            }

        endif;

    }

	public function getImageWatermarked($id, $mobile = false)
	{ return;
		// bu resim varligi kontrol edilir

		if($mobile == true):
			$photo = DB::table('villa_photos')->where('id', $id)->first();

			if(!empty($photo)):
				$villaPhotoPath = $this->villaPhotoPath . '/' . $photo->path . '/mobile/';
				$this->writePath = $villaPhoto = $villaPhotoPath  . $photo->name;
				// dd($villaPhotoPath);
				if(File::exists($villaPhotoPath)):
					if(File::exists($villaPhoto)):

						// bu resim zaten olustuulmustur asset olarak sayfaya dondur serseri
						return asset($villaPhoto);
					else:
						// bu resim kendi klasorumuzde olusturulacaktir

						$watermark = file_get_contents($this->watermark_path);
						$watermark = $this->imageHandler:: make($watermark);

						$image = file_get_contents($this->serverVillaGalleryPath . '/' . $photo->path . '/' . $photo->name);
						$img = $this->imageHandler:: make($image);

						//resmin watermarkli ham hali $this->img icindedir.
						$this->img = $img->insert($watermark, 'center');

						$this->resizer();
						// $img->save('villa/' . $photo->path . '/' . $photo->name);
						return asset($villaPhoto);

						dd($this->serverVillaGalleryPath . '/' . $photo->path . '/' . $photo->name);
					endif;
				else:
					// resim hic olusturulmamistir olusturulmalidir
					// dd($this->serverVillaGalleryPath . '/' . $photo->path . '/' . $photo->name);
					// $watermarker = file_get_contents($this->watermarker_path);
					// dd($this->watermark_path);
					try {
						File::makeDirectory('villa/' . $photo->path);

					} catch (\Exception $e) {

					}
					try {
						File::makeDirectory('villa/' . $photo->path . '/mobile' );
					} catch (\Exception $e) {

					}
					$watermark = file_get_contents($this->watermark_path);
					$watermark = $this->imageHandler:: make($watermark);

					$image = file_get_contents($this->serverVillaGalleryPath . '/' . $photo->path . '/' . $photo->name);
					$img = $this->imageHandler:: make($image);
					// thumb dosyasini burada resize edip sayfayi yuklemeliyiz.

					$this->img = $img->insert($watermark, 'center');

					$this->resizer();
					// $img->save('villa/' . $photo->path . '/' . $photo->name);

					// $img->save('villa/' . $photo->path . '/' . $photo->name);
					return asset($villaPhoto);
				endif;
			endif;
		else:

			$photo = DB::table('villa_photos')->where('id', $id)->first();

			if(!empty($photo)):
				$villaPhotoPath = $this->villaPhotoPath . '/' . $photo->path;
				$villaPhoto = $villaPhotoPath . '/' . $photo->name;

				if(File::exists($villaPhotoPath)):

					if(File::exists($villaPhoto)):


						// bu resim zaten olustuulmustur asset olarak sayfaya dondur serseri
						return asset($villaPhoto);
					else:
						// bu resim kendi klasorumuzde olusturulacaktir

						$watermark = file_get_contents($this->watermark_path);
						$watermark = $this->imageHandler:: make($watermark);


						$image = file_get_contents($this->serverVillaGalleryPath . '/' . $photo->path . '/' . $photo->name);
						$img = $this->imageHandler:: make($image);

						$img->insert($watermark, 'center');
						$img->save('villa/' . $photo->path . '/' . $photo->name);
						return asset($villaPhoto);

						dd($this->serverVillaGalleryPath . '/' . $photo->path . '/' . $photo->name);
					endif;
				else:
					// resim hic olusturulmamistir olusturulmalidir
					$watermark = file_get_contents($this->watermark_path);
					$watermark = $this->imageHandler:: make($watermark);

					$image = file_get_contents($this->serverVillaGalleryPath . '/' . $photo->path . '/' . $photo->name);

					$img = $this->imageHandler::make($image);
					$img->insert($watermark, 'center');

//                    dd(public_path('villa/' . $photo->path));
//                    dd(public_path('villa/' . $photo->path))
					File::makeDirectory(public_path() . '/villa/' . $photo->path, 0777, true);

					$img->save('villa/' . $photo->path . '/' . $photo->name);
					return asset($villaPhoto);
				endif;
			endif;
		endif;
	}
	public function getImageByPath($path)
	{ return;
		if(!File::exists($path)):
			// serverden kontrol et
			try {
				$file = file_get_contents($this->server_ip . '/' . $path);

			} catch (\Exception $e) {
				// boyle bir resim olmayabilir resim hazirlaniyor ihtiyacimiz var .. default bir resim dondert.

				return asset($path);
			}
		    if(empty($file)):
                return asset($path);
            endif;
			$this->folderCreate($path);
			$img = $this->imageHandler::make($file);
			$img->save($path, 90);
//			return Helper::cdn_url($path);
			return asset($path);
			// dd($file);
		else:
//			return Helper::cdn_url($path);
			return asset($path);
		endif;
	}
	public function getVillaImageByPath($path, $mobile = false)
	{
		 return;
		// type a gore yuklenecektir tum typlar sunlardir
		if($mobile):
			$path = $path . '/thumb/';
			if(!File::exists($path)):
				// serverden kontrol et
				try {
					$file = file_get_contents($this->server_ip . '/' . $path);
				} catch (\Exception $e) {
					// boyle bir resim olmayabilir resim hazirlaniyor ihtiyacimiz var .. default bir resim dondert.
//					return Helper::cdn_url($path);
					return asset($path);
				}
				$this->folderCreate($path);
				$img = $this->imageHandler:: make($file);
				$img->save($path, 90);
//                return Helper::cdn_url($path);
                return asset($path);
            // dd($file);

			else:
//				return Helper::cdn_url($path);
				return asset($path);
			endif;
		else:
			if(!File::exists($path)):
				// serverden kontrol et
				try {
					$file = file_get_contents($this->server_ip . '/' . $path);
				} catch (\Exception $e) {
					// boyle bir resim olmayabilir resim hazirlaniyor ihtiyacimiz var .. default bir resim dondert.
//					return Helper::cdn_url($path);
					return asset($path);
				}
				$this->folderCreate($path);
			    try {
                    $img = $this->imageHandler::make($file);
                    $img->save($path, 90);
                }catch(\Exception $e) {
//                    return Helper::cdn_url('images/image_null.jpg');
                    return asset('images/image_null.jpg');
                }

//				return Helper::cdn_url($path);
				return asset($path);
				// dd($file);

			else:

//				return Helper::cdn_url($path);
				return asset($path);
			endif;
//            return Helper::cdn_url('images/image_null.jpg');
            return asset('images/image_null.jpg');
		endif;
	}
	public function getVIllaImage($id, $type )
	{
		// type a gore yuklenecektir tum typlar sunlardir
		switch($type) {
			case 'list_image_thumb':
				$villa = DB::table('villas')->find($id);
				if(!File::exits($villa->list_image_thumb)):




					// serverdan alakali olan resmi getir
					// dosya kaydedilirken tum yolun incelenmesi gerekmektedir
				else:
//					return Helper::cdn_url($villa->list_image_thumb);
					return asset($villa->list_image_thumb);
				endif;

			break;
			case 'banner_image':
				$villa = DB::table('villas')->find($id);
				if(!File::exits($villa->banner_image)):
					// serverdan alakali olan resmi getir
				else:
//					return Helper::cdn_url($villa->banner_image);
					return asset($villa->banner_image);
				endif;
			break;
			case 'banner_image_thumb':
				$villa = DB::table('villas')->find($id);
				if(!File::exits($villa->banner_image_thumb)):
					// serverdan alakali olan resmi getir
				else:
//					return Helper::cdn_url($villa->banner_image_thumb);
					return asset($villa->banner_image_thumb);
				endif;
			break;
			case 'banner_image_mobile':
				$villa = DB::table('villas')->find($id);
				if(!File::exits($villa->banner_image_mobile)):
					// serverdan alakali olan resmi getir
				else:
//					return Helper::cdn_url($villa->banner_image_mobile);
					return asset($villa->banner_image_mobile);
				endif;
			break;
			case 'banner_image_mobile_thumb':
				$villa = DB::table('villas')->find($id);
				if(!File::exits($villa->banner_image_mobile_thumb)):
					// serverdan alakali olan resmi getir
				else:
//					return Helper::cdn_url($villa->banner_image_mobile_thumb);
					return asset($villa->banner_image_mobile_thumb);
				endif;
			break;
		}
	}
	public function getAllImages()
	{ return;
		// uploads/villa/banner/{code}/{name}
		// uploads/villa/gallery/{code}/{name}
		$villas = Villa::with('photos')->get();

		$offset = $this->server_ip;

		$fork = new MultiProcess($this->imageHandler);


		exit();


	}
	// bana kizmayin neden buraya yazdin diye,
	public function anti_cache($file_path)
	{
	    return md5(filemtime(sprintf(getcwd()  . '/%s', $file_path)));
	}

	protected function resizer($inputFile=null)
	{
        if(is_null($inputFile)):
	        $w = 698;
	        $h = 465;

    		// try {
      //   		$img=Image::make( Storage::get( $this->originalPath ) )->orientate();
    		// } catch (\Exception $e) {
    		// 	return $this->getDefault(['width' => $w, 'height' => $h], 'urun');
    		// }

	        $this->img->resize($w, $h, function ($constraint) {
		            $constraint->aspectRatio();
		            $constraint->upsize();
		      });
	        // dd($this->writePath);
	       	$this->img->save(($this->writePath), 80);

	       	// $cnv=Image::canvas($w, $h, '#ffffff');

	       	// $cnv->insert(($this->writePath), "center");
	        // $cnv->save(($this->writePath) );

        else:
        	$w = $this->w;
        	$h = $this->h;
        	$img=Image::make( $inputFile )->orientate();
	        $img->resize($w, $h, function ($constraint) {
		            $constraint->aspectRatio();
		            $constraint->upsize();
		      });

	       	$img->save(Storage::path($this->writePath));

	       	$cnv=Image::canvas($w, $h, '#ffffff');

	       	$cnv->insert(Storage::path($this->writePath), "center");
	        $cnv->save(Storage::path($this->writePath) );
        endif;

//        return Helper::cdn_url(($this->writePath));
        return asset(($this->writePath));
	}
}
