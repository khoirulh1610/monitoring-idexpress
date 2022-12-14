<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        
        $delivered = Paket::where('operationType', '10')->where('returnFlag','<>',1)->count();
        $gagal = Paket::whereIn('operationType', ['18','19'])->where('returnFlag','<>',1)->count();
        $onprocess = Paket::whereIn('operationType',['00','04','05','09'])->where('returnFlag','<>',1)->count();
        $plus3 = Paket::whereIn('operationType',['00','04','05','09'])->where('overdue','>',3)->where('returnFlag','<>',1)->count();
        $plus7 = Paket::whereIn('operationType',['00','04','05','09'])->where('overdue','>',7)->where('returnFlag','<>',1)->count();
        $paket = Paket::take(10)->orderBy('last_cek_at','desc')->where('returnFlag','<>',1)->get();
        $tidak_valid = Paket::whereIn('operationType',['xx'])->count();
        $belum_proses = Paket::whereNull('operationType')->count();
        $rts = Paket::where('returnFlag',1)->count();
        $all = Paket::count();
        return view('dashboard', compact('delivered', 'onprocess', 'gagal','paket','plus3','plus7','belum_proses','tidak_valid','rts','all'));
    }
}
