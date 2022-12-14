<?php

namespace App\Http\Controllers;

use App\Helpers\Tracking;
use App\Helpers\Wa;
use App\Jobs\CekresiJOb;
use App\Models\Apiwa;
use App\Models\Notifikasi;
use App\Models\Paket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class PaketController extends Controller
{
    public function index(Request $request)
    {
        
        $qpaket = " 1=1";
        if($request->filter_from){
            // $paket->where('pick_up_start_time','>=',Carbon::createFromFormat('d-m-Y', $request->filter_from)->format('Y-m-d'));
            $qpaket .= " and pick_up_start_time >= '".Carbon::createFromFormat('d-m-Y', $request->filter_from)->format('Y-m-d')."'";
        }
        if($request->filter_to){
            // $paket->where('pick_up_start_time','<=',Carbon::createFromFormat('d-m-Y', $request->filter_to)->format('Y-m-d').' 23:59');
            $qpaket .= " and pick_up_start_time <= '".Carbon::createFromFormat('d-m-Y', $request->filter_to)->format('Y-m-d').' 23:59'."'";
        }
        if($request->filter_status=='Delivered'){
            // $paket->where('operationType','10');
            $qpaket .= " and operationType = '10'";
        }
        if($request->filter_status=='Dalam Proses'){
            // $paket->whereIn('operationType',['00','04','05','09']);
            $qpaket .= " and operationType in ('00','04','05','09')";
        }
        if($request->filter_status=='Gagal Kirim'){
            // $paket->whereIn('operationType',['18','19']);
            $qpaket .= " and operationType in ('18','19')";
        }
        if($request->filter_status=='Dalam Proses Lebih Dari 3 Hari'){
            // $paket->whereIn('operationType',['00','04','05','09'])->where('overdue','>',3);
            $qpaket .= " and operationType in ('00','04','05','09') and overdue > 3";
        }
        if($request->filter_status=='Dalam Proses Lebih Dari 7 Hari'){
            // $paket->whereIn('operationType',['00','04','05','09'])->where('overdue','>',7);
            $qpaket .= " and operationType in ('00','04','05','09') and overdue > 7";
        }
        if($request->filter_status=='tidak_valid'){
            // $paket->whereIn('operationType',['00','04','05','09'])->where('overdue','>',7);
            $qpaket .= " and operationType in ('xx')";
        }
        if($request->filter_status=='belum_cek'){
            // $paket->whereNull('operationType');
            $qpaket .= " and operationType is null";
        }
        if($request->filter_by){
            // $paket->where($request->filter_by,'like','%'.$request->keyword.'%');
            $qpaket .= " and ".$request->filter_by." like '%".$request->keyword."%'";
        }
        $paket = DB::table("pakets")->whereRaw($qpaket)->paginate(10);
        // $paket->paginate(10);
        // return $paket;
        return view('paket.index', compact('paket'));
    }
    
    public function show($id)
    {
        $paket = Paket::where('id',$id)->orWhere('waybill_no',$id)->first();
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
                $paket->waybill_status = 'TIDAK VALID';
                $paket->operationType = 'xx';
                $paket->last_cek_at = Carbon::now(); 
                $paket->save();
                return redirect()->back()->with('error', 'TIDAK VALID');
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
            $paket->rp_cod = 'Rp. '.number_format($data['cod_amount']);
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
                $apiwa = Apiwa::where('status',1)->first();
                $kirim = Wa::send($apiwa->id,[
                    "phone" => $paket->recipient_phone,
                    "message" => Wa::ReplaceArray($paket,$template_notif->copywriting),
                ]);                
            }
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        $paket = Paket::find($id);
        if($paket){
            $paket->delete();
        }
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function deleteAll(Request $request)
    {
        $paket = Paket::truncate();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function update(Request $request, $id)
    {
        $value = $request->v;
        $paket = Paket::find($id);
        if($paket){
            if($value=='terkirim'){
                $paket->operationType = '10';
                $paket->status = 'Delivered';
                $paket->crm_monitor = null;
                $paket->claim = null;
                $paket->returnFlag = 0; 
                $paket->manual_status = 'Manual Action';
                $paket->save();
            }

            if($value=='claim'){                
                $paket->claim = 'Y';
                $paket->manual_status = 'Pengajuan Claim';
                $paket->save();
            }

            if($value=='crm_monitoring'){                
                $paket->crm_monitor = 'Y';
                $paket->manual_status = 'Monitoring CRM';
                $paket->save();
            }
            if($value=='rts'){                
                $paket->returnFlag = 1;
                $paket->manual_status = 'returnFlag Manual';
                $paket->save();
            }
        }
        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }
    

        public function crmMonitor(Request $request)
    {
        $paket = Paket::whereNotNull('crm_monitor')->paginate(10);
        return view('paket.index', compact('paket'));
    }
    
    public function claim(Request $request)
    {
        $paket = Paket::whereNotNull('claim')->paginate(10);
        return view('paket.index', compact('paket'));
    }

    public function rts(Request $request)
    {
        $paket = Paket::where('returnFlag',1)->paginate(10);
        return view('paket.index', compact('paket'));
    }
    
}
