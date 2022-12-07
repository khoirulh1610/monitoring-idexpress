<?php

namespace App\Http\Controllers;

use App\Models\Apiwa;
use Illuminate\Http\Request;

class ApiwaController extends Controller
{
    public function index(Request $request)
    {
        $apiwa = Apiwa::all();
        return view('apiwa.index', compact('apiwa'));
    }
    
    public function create()
    {
        return view('apiwa.create');
    }

    
}
