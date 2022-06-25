<?php

namespace App\Http\Controllers;

use App\District;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getDistricts(Request $request)
    {
        $areaId = $request->get('area_id');
        $areas = District::where('area_id', $areaId)->get();
        return response()->json($areas);
    }


}
