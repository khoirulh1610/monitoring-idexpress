<?php

namespace App\Http\Controllers;

use App\Models\Apiwa;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $notifikasi = Notifikasi::get();
        }
        $notifikasi = Notifikasi::get();
        $device = Apiwa::get();
        $keys = Schema::getColumnListing('pakets');
        return view('notifikasi.index', compact('notifikasi', 'device','keys'));
    }

    public function credit(Request $request)
    {
        if ($request->ajax()) {
            $notifikasi = Notifikasi::where('id', $request->id)->first();
            return $notifikasi;
        }
    }

    public function store(Request $request)
    {
        if ($request->id_notifikasi) {
            $notifikasi = Notifikasi::where('id', $request->id_notifikasi)->first();
        } else {
            $notifikasi = new Notifikasi();
        }
        $notifikasi->name           = $request->nama_notifikasi;
        $notifikasi->api_id         = $request->device_notifikasi;
        $notifikasi->copywriting    = $request->message_notifikasi;
        $notifikasi->status         = $request->status_notifikasi;
        $notifikasi->delay_min     = $request->delay_min;
        $notifikasi->delay_max     = $request->delay_max;
        $notifikasi->target_notif  = $request->target_notif;
        $notifikasi->save();

        return redirect('/setting/notifikasi');
    }

    public function remove(Request $request)
    {
        $notifikasi     = Notifikasi::where('id', $request->id)->delete();
        return redirect('setting/notifikasi');
    }
}
