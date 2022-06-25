<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repo\ImageProcess\src\MultiProcess;
use App\Villa;

class TestController extends Controller
{
    public function getAllImages()
	{
		// uploads/villa/banner/{code}/{name}
		// uploads/villa/gallery/{code}/{name}
		$villas = Villa::with('photos')->get();
		$fork = new MultiProcess();
		$fork->getVillaImages();
		// tum resimlerin alinmasi tamamlandi
	}
}
