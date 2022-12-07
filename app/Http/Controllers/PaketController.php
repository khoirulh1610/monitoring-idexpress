<?php

namespace App\Http\Controllers;

use App\Helpers\Tracking;
use App\Helpers\Wa;
use App\Jobs\CekresiJOb;
use App\Models\Notifikasi;
use App\Models\Paket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class PaketController extends Controller
{
    public function index(Request $request)
    {
        
        $paket = Paket::paginate(10);
        if($request->filter_from){
            $paket = Paket::where('pick_up_start_time','>=',Carbon::createFromFormat('d-m-Y', $request->filter_from)->format('Y-m-d'))->paginate(10);
        }
        if($request->filter_to){
            $paket = Paket::where('pick_up_start_time','<=',Carbon::createFromFormat('d-m-Y', $request->filter_to)->format('Y-m-d').' 23:59')->paginate(10);
        }
        if($request->filter_status=='Delivered'){
            $paket = Paket::where('operationType','10')->paginate(10);
        }
        if($request->filter_status=='Dalam Proses'){
            $paket = Paket::where('operationType',['00','04','05','09'])->paginate(10);
        }
        if($request->filter_status=='Gagal Kirim'){
            $paket = Paket::where('operationType',['18'])->paginate(10);
        }
        if($request->filter_status=='Dalam Proses Lebih Dari 3 Hari'){
            $paket = Paket::where('operationType',['00','04','05','09'])->where('overdue','>',3)->paginate(10);
        }
        if($request->filter_status=='Dalam Proses Lebih Dari 7 Hari'){
            $paket = Paket::where('operationType',['00','04','05','09'])->where('overdue','>',7)->paginate(10);
        }
        // $paket->paginate(10);
        return view('paket.index', compact('paket'));
    }
    
    public function show($id)
    {
        $paket = Paket::find($id);
        if($paket){
            $json_paket = Tracking::idexpress($paket->waybill_no);
            if($json_paket['total']==1){
                $data = $json_paket['data'][0];
                try {
                    $data_up = $data['scanLineVOS'][0];
                    if($data_up){
                        $status = \App\Models\IdexpressStatus::where('operationType',$data_up['operationType'])->first();
						$col = $status->col ?? 'operationType';
                        $paket->operationType = $data_up['operationType'];                        
                        $paket->waybill_status = str_replace(["<b>","</b>"], "", $status->description).' '. $data_up[$col];
                        $paket->save();
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
                return view('paket.show', compact('paket','data'));
            }else{
                return redirect()->back()->with('error', 'Data tidak ditemukan');
            }            
        }
        return redirect()->back();
    }

    public function upload()
    {
        return view('paket.upload');
    }

    public function doupload(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $file->move('uploads', $filename);
        $filepath = public_path('uploads/' . $filename);
        $file = fopen($filepath, 'r');
        $header = fgetcsv($file);
        $escapedHeader = [];
        foreach ($header as $key => $value) {
            $lheader = strtolower($value);
            $escapedItem = preg_replace('/[^a-z]/', '_', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        while ($columns = fgetcsv($file)) {
            if ($columns[0] == "") {
                continue;
            }
            // foreach ($columns as $key => &$value) {
            //     $value = preg_replace('/\D/', '', $value);
            // }
            $data = array_combine($escapedHeader, $columns);
            // var_dump($data);
            $paket = Paket::where('waybill_no', $data['waybill_no'])->first();
            if (!$paket) {
                $paket = new Paket;
            }
            $paket->batch_id = $data['batch_id'];
            $paket->order_no = $data['order_no'];
            $paket->waybill_no = $data['waybill_no'];
            $paket->order_source = $data['order_source'];
            $paket->service_type = $data['service_type'];
            // $paket->pick_up_start_time = $data['pick_up_start_time'] ?? null;
            // $paket->pick_up_end_time = $data['pick_up_end_time'] ?? null;
            $paket->destination = $data['destination'];
            $paket->standard_shipping_fee = $data['standard_shipping_fee'];
            $paket->insurance = $data['insurance'];
            $paket->handling_fee = $data['handling_fee'];
            $paket->cod_amount = $data['cod_amount'];
            $paket->total_freight = $data['total_freight'];
            $paket->charged_to_recipient = $data['charged_to_recipient'];
            $paket->charged_to_sender = $data['charged_to_sender'];
            $paket->recipient_name = $data['recipient_name'];
            $paket->recipient_phone = $data['recipient_phone'];
            $paket->recipient_address = $data['recipient_address'];
            $paket->zip_code = $data['zip_code'];
            $paket->save();
        }
        // dispatch(new CekresiJOb());
        return redirect()->route('paket')->with('success', 'Data berhasil diupload');
    }

    
    public function resendNotif($id)    
    {
        $paket = Paket::find($id);
        if($paket){
            $template_notif = Notifikasi::where('name', 'update-status')->first();                 
            if($template_notif){
                $kirim = Wa::send($template_notif->api_id,[
                    "phone" => $paket->recipient_phone,
                    "message" => Wa::ReplaceArray($paket,$template_notif->copywriting),
                ]);                
            }
        }
        return redirect()->back();
    }
}
