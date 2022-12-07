<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $delivered = Paket::where('operationType', '10')->count();
        $gagal = Paket::whereIn('operationType', ['18','19'])->count();
        $onprocess = Paket::whereIn('operationType',['00','04','05','09'])->count();
        $plus3 = Paket::whereIn('operationType',['00','04','05','09'])->where('overdue','>',3)->count();
        $plus7 = Paket::whereIn('operationType',['00','04','05','09'])->where('overdue','>',7)->count();
        $paket = Paket::take(10)->orderBy('id','desc')->get();
        return view('dashboard', compact('delivered', 'onprocess', 'gagal','paket','plus3','plus7'));
    }
}
