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

class Cekresi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cek:resi';

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
        exit;
        $paket = Paket::where('operationType_before', '<>', '10')->orWhereNull('operationType_before')->update(['operationType_before' => DB::raw('operationType')]);
        $paket = Paket::where('operationType', '<>', '10')->orWhereNull('operationType')->get();
        $temp_notif = Notifikasi::where('name', 'update-status')->first();
        $this->info('Total Paket : ' . count($paket));
        foreach ($paket as $p) {
            $cek = Tracking::idexpress($p->waybill_no);
            // $this->info(json_encode($cek));
            if ($cek['total'] > 0) {
                $data = $cek['data'];
                foreach ($data as $dd) {
                    $data2 = $dd['scanLineVOS'];
                    if($data2){
                        $last_id = 1;
                        foreach ($data2 as $d) {
                            $cek = PaketsLogTracking::where('waybill_no', $p->waybill_no)->where('scanLineVOS_id', $d['id'])->first();
                            if (!$cek) {
                                $log = new PaketsLogTracking;
                                $log->orderNo = $p->orderNo;
                                $log->waybill_no = $p->waybill_no;
                                $log->shippingTime = $dd['shippingTime'];
                                $log->senderName = $dd['senderName'];
                                $log->senderCityName = $dd['senderCityName'];
                                $log->senderDistrictName = $dd['senderDistrictName'];
                                $log->recipientName = $dd['recipientName'];
                                $log->recipientCityName = $dd['recipientCityName'];
                                $log->recipientDistrictName = $dd['recipientDistrictName'];
                                $log->waybillStatus = $dd['waybillStatus'];
                                $log->podFlag = $dd['podFlag'];
                                $log->problemFlag = $dd['problemFlag'];
                                $log->returnFlag = $dd['returnFlag'];
                                $log->voidFlag = $dd['voidFlag'];
                                $log->pickupFlag = $dd['pickupFlag'];

                                $log->scanLineVOS_id = $d['id'];
                                $log->recordTime = $d['recordTime'];
                                $log->operationTime = $d['operationTime'];
                                $log->operationBranchId = $d['operationBranchId'];
                                $log->operationBranchName = $d['operationBranchName'];
                                $log->previousBranchName = $d['previousBranchName'];
                                $log->nextLocationName = $d['nextLocationName'];
                                $log->nextBranchName = $d['nextBranchName'];
                                $log->operationUserId = $d['operationUserId'];
                                $log->operationUserName = $d['operationUserName'];
                                $log->courierName = $d['courierName'];
                                $log->driverName = $d['driverName'];
                                $log->shiftName = $d['shiftName'];
                                $log->operationType = $d['operationType'];
                                $log->bagNo = $d['bagNo'];
                                $log->vehicleTagNo = $d['vehicleTagNo'];
                                $log->licensePlate = $d['licensePlate'];
                                $log->signer = $d['signer'];
                                $log->photoUrl = $d['photoUrl'];
                                $log->signatureUrl = $d['signatureUrl'];
                                $log->problemType = $d['problemType'];
                                $log->problemCode = $d['problemCode'];
                                $log->registerReasonBahasa = $d['registerReasonBahasa'];
                                $log->returnTypeBahasa = $d['returnTypeBahasa'];
                                $log->transportationMethod = $d['transportationMethod'];
                                $log->save();
                            }

                            if ($last_id == 1) {
                                try {
                                    $status = \App\Models\IdexpressStatus::where('operationType',$d['operationType'])->first();
                                    $col = $status->col ?? 'operationType';                                                 
                                    $waybill_status = str_replace(['<b>','</b>','<b class="text-danger">'], "", $status->description).' '. $d[$col]; 
                                    // Hitung overdue
                                    $now = $d['operationTime'] ? new \DateTime($d['operationTime']) : new \DateTime();
                                    $overdue = new \DateTime($dd['shippingTime']);
                                    $interval = $now->diff($overdue);
                                    $overdue = $interval->format('%a');
                                    // end cek overdue
                                    if ($d['operationType'] == '10') {
                                        Paket::where('id', $p->id)->update(['operationType' => $d['operationType'], 'pick_up_end_time' => $d['operationTime'],'waybill_status' => $waybill_status,'status'=>$status->note,'overdue'=>$overdue,'last_cek_at'=>Date('Y-m-d H:i:s')]);
                                    } else {
                                        Paket::where('id', $p->id)->update(['operationType' => $d['operationType'],'waybill_status' => $waybill_status,'status'=>$status->note,'overdue'=>$overdue,'last_cek_at'=>Date('Y-m-d H:i:S')]);
                                    }
                                    $this->info($p->id.'=>'.$p->waybill_no);
                                    // kirim notifikasi berdasarkan status
                                    // if ($p->operationType_before != $d['operationType']) {
                                    //     $notif = new Message();
                                    //     $notif->api_id = $temp_notif->api_id;
                                    //     $notif->phone = $p->recipient_phone;
                                    //     $notif->message = Wa::ReplaceArray($p,$temp_notif->copywriting);
                                    //     $notif->status = 0;
                                    //     $notif->save();
                                //     $kirim_notif = NotifikasiJob::dispatch($notif);
                                // }
                            } catch (\Throwable $th) {
                                //throw $th;
                            }
                        }
                        if ($last_id === count($data2)) {
                            Paket::where('id', $p->id)->update(['pick_up_start_time' => $d['operationTime']]);
                        }
                        $last_id++;
                    }
                    }
                }
            }
        }
    }
}
