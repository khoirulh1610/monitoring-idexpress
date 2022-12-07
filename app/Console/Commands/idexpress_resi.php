<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Paket;
use App\Helpers\Tracking;
use App\Helpers\Wa;
use App\Jobs\NotifikasiJob;
use App\Models\Message;
use App\Models\Notifikasi;
use App\Models\PaketsLogTracking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\IdexpressStatus;
use Carbon\Carbon;

class idexpress_resi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'idexpress:resi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $paket = Paket::where('operationType_before', '<>', '10')->orWhereNull('operationType_before')->update(['operationType_before' => DB::raw('operationType')]);
        $resi = Paket::where('operationType', '<>', '10')->take(10)->where('last_cek_at','<=',Carbon::now()->subMinute(5))->orwhereNull('last_cek_at')->pluck('waybill_no')->toArray();
        $this->info(count($resi)."==>".Carbon::now()->subMinute(10));
        if(count($resi)==0){
            exit;
        }
        $all_Resi = implode(",",$resi);        
        $cek = Tracking::idexpress($all_Resi);
        $this->info("https://rest.idexpress.com/retail/waybill-scan-lines/search-track-batch?waybillNo=".$all_Resi);        
        if ($cek['total'] > 0) {
            $temp_notif = Notifikasi::where('name', 'update-status')->first();
            $data = $cek['data'];
            foreach ($data as $dd) {
                $data2 = $dd['scanLineVOS'];
                if($data2){
                    $this->info($dd['waybillNo'].'=>'.json_encode($data2[0])."\n");
                    $up = $data2[0];                    
                    $cek_paket = Paket::where('waybill_no',$up['waybillNo'])->first();                    
                    if($cek_paket){
                        if($cek_paket->operationType!=$up['operationType']){
                            $status = IdexpressStatus::where('operationType',$up['operationType'])->first();
                            $col = $status->col ?? 'operationType';                                                 
                            $waybill_status = str_replace(['<b>','</b>','<b class="text-danger">'], "", $status->description).' '. $up[$col]; 
                            // Hitung overdue
                            $now = $up['operationTime'] ? new \DateTime($up['operationTime']) : new \DateTime();
                            $overdue = new \DateTime($dd['shippingTime']);
                            $interval = $now->diff($overdue);
                            $overdue = $interval->format('%a');
                            // end cek overdue
                            if ($up['operationType'] == '10') {
                                Paket::where('id', $cek_paket->id)->update(['operationType' => $up['operationType'],'pick_up_start_time'=>$dd['shippingTime'], 'pick_up_end_time' => $up['operationTime'],'waybill_status' => $waybill_status,'status'=>$status->note,'overdue'=>$overdue,'last_cek_at'=>Date('Y-m-d H:i:s')]);
                            } else {
                                Paket::where('id', $cek_paket->id)->update(['operationType' => $up['operationType'],'pick_up_start_time'=>$dd['shippingTime'],'waybill_status' => $waybill_status,'status'=>$status->note,'overdue'=>$overdue,'last_cek_at'=>Date('Y-m-d H:i:s')]);
                            }
                            //  kirim notifikasi berdasarkan status                                   
                            try {
                                $notif = new Message();
                                // $notif->api_id = $temp_notif->api_id;
                                $notif->phone = $cek_paket->recipient_phone;
                                $notif->message = Wa::ReplaceArray($cek_paket,$temp_notif->copywriting);
                                $notif->waybill_no = $cek_paket->waybill_no;
                                $notif->operationType = $up['operationType'];
                                $notif->status = 0;
                                $notif->delay = rand($temp_notif->delay_min ?? 1,$temp_notif->delay_max?? 10);
                                $notif->save();
                            } catch (\Throwable $th) {
                                //throw $th;
                            }
                        }else{
                            Paket::where('waybill_no',$dd['waybillNo'])->update(['last_cek_at'=>Date('Y-m-d H:i:s')]);
                        }
                    }
                    
                }else{
                    $this->info('Belum Data '.$dd['waybillNo']."\n");
                    Paket::where('waybill_no',$dd['waybillNo'])->update(['status'=>'Tidak ditemukan','last_cek_at'=>Date('Y-m-d H:i:s')]);
                }
                
            }
        }
        self::handle();
    }
    
}
