<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VillatypeController extends Controller
{
    public function index()
    {
        return view('type.index');
    }
}
