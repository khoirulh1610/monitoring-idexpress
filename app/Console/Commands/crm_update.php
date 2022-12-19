<?php

namespace App\Console\Commands;

use App\Helpers\Tracking;
use App\Helpers\Wa;
use App\Models\IdexpressStatus;
use App\Models\Message;
use App\Models\Notifikasi;
use App\Models\Paket;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class crm_update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:crm';

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
        $resi = Paket::whereNotNull('crm_monitor')->take(10)->where('last_cek_at','<=',Carbon::now()->subMinute(1))->orwhereNull('last_cek_at')->pluck('waybill_no')->toArray();
        $this->info(count($resi)."==>".Carbon::now()->subMinute(10));
        if(count($resi)==0){
            return false;
        }
        $all_Resi = implode(",",$resi);        
        $cek = Tracking::idexpress($all_Resi);
        $this->info("https://rest.idexpress.com/retail/waybill-scan-lines/search-track-batch?waybillNo=".$all_Resi);        
        if ($cek['total'] > 0) {
            $temp_notif = Notifikasi::where('name', 'update-status')->first();
            $data = $cek['data'];
            foreach ($data as $dd) {
                $podFlag = $dd['podFlag'];
                $problemFlag = $dd['problemFlag'];
                $returnFlag = $dd['returnFlag'];
                $voidFlag = $dd['voidFlag'];
                $pickupFlag = $dd['pickupFlag'];
                $data2 = $dd['scanLineVOS'];
                $rs = count($dd['scanLineVOS'])-1;
                $this->info($rs);
                if($data2){
                    $this->info($dd['waybillNo'].'=>'.json_encode($data2[0])."\n");
                    $up = $data2[0];    
                    $fsresi = $data2[$rs];
                    $cek_paket = Paket::where('waybill_no',$up['waybillNo'])->first();                    
                    if($cek_paket){
                        if($cek_paket->operationType!=$up['operationType']){
                            $status = IdexpressStatus::where('operationType',$up['operationType'])->first();
                            if(!$status){
                                Wa::send(1,['phone'=>'6285232843165','message'=>'Status tidak ditemukan '.$up['operationType'].' Pada Resi : '.$dd['waybillNo']]);
                                return false;
                            }
                            $col = $status->col ?? 'operationType';                                                 
                            $waybill_status = str_replace(['<b>','</b>','<b class="text-danger">'], "", $status->description).' '. $up[$col]; 
                            // Hitung overdue
                            $tgl_kirim = $dd['shippingTime'];
                            if($fsresi){
                                $tgl_kirim = $fsresi['recordTime'];
                            }
                            $now = $up['operationTime'] ? new \DateTime($up['operationTime']) : new \DateTime();
                            $overdue = new \DateTime($tgl_kirim);
                            $interval = $now->diff($overdue);
                            $overdue = $interval->format('%a');
                            $problemCode = $up['problemCode'] ?? '';
                            // end cek overdue
                            $data_update = [
                                'operationType' => $up['operationType'],
                                'pick_up_start_time'=> $tgl_kirim,
                                'waybill_status' => $waybill_status,
                                'status'=>$status->note,
                                'overdue'=>$overdue,
                                'podFlag'=>$podFlag,
                                'problemFlag'=>$problemFlag,
                                'returnFlag'=>$returnFlag ?? ($up['operationType']=='19' ? 1 : 0),
                                'voidFlag'=>$voidFlag,
                                'pickupFlag'=>$pickupFlag,
                                'problemCode'=>$problemCode,
                                'manual_status'=> $up['operationType']=='19' ? 'Pindah RTS dari operationType:19' : null,
                                'claim'=> ($problemCode=='3013') ? 'Y' : null,
                                'last_cek_at'=>Date('Y-m-d H:i:s')
                            ];
                            if ($up['operationType'] == '10' || $podFlag==1) {
                                $data_update['pick_up_end_time'] = $up['operationTime'];                               
                                $data_update['crm_monitor'] = null;                               
                            } 
                            if ($up['operationType'] == '19' || $returnFlag==1 || $podFlag==1 ) {
                                $data_update['crm_monitor'] = null;                               
                            }
                            Paket::where('id', $cek_paket->id)->update($data_update);
                            //  kirim notifikasi berdasarkan status                                   
                            try {
                                $cek_paket = Paket::where('waybill_no',$up['waybillNo'])->first();                    
                                if($cek_paket && $status->kirim_wa==1 && $problemFlag==0){
                                    $notif = new Message();                                
                                    $notif->phone = $cek_paket->recipient_phone;
                                    $notif->message = Wa::ReplaceArray($cek_paket,$temp_notif->copywriting);
                                    $notif->waybill_no = $cek_paket->waybill_no;
                                    $notif->operationType = $up['operationType'];
                                    $notif->status = 0;
                                    $notif->delay = rand($temp_notif->delay_min ?? 1,$temp_notif->delay_max?? 10);
                                    $notif->save();
                                }                                
                            } catch (\Throwable $th) {
                                Log::error($th->getMessage());
                            }
                        }else{
                            Paket::where('waybill_no',$dd['waybillNo'])->update(['last_cek_at'=>Date('Y-m-d H:i:s')]);
                        }
                    }
                    
                }else{
                    $this->info('Belum Data '.$dd['waybillNo']."\n");
                    Paket::where('waybill_no',$dd['waybillNo'])->update(['status'=>'TIDAK VALID','operationType'=>'xx','last_cek_at'=>Date('Y-m-d H:i:s')]);
                }
                
            }
        }
        self::handle();
    }
}
