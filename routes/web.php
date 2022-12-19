<?php

use App\Helpers\Tracking;
use App\Helpers\Wa;
use App\Http\Controllers\NotifikasiController;
use App\Models\IdexpressStatus;
use App\Models\Message;
use App\Models\Notifikasi;
use App\Models\Paket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', 'Auth\LoginController@index')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login.post');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::get('/paket', 'PaketController@index')->name('paket');
    Route::get('/paket/show/{id}', 'PaketController@show');
    Route::get('/paket/upload', 'PaketController@upload');
    Route::post('/paket/upload', 'PaketController@doupload');
    Route::get('/paket/resend-notif/{id}', 'PaketController@resendNotif');
    Route::get('/paket/delete/{id}', 'PaketController@delete');
    Route::post('/paket/delete-all', 'PaketController@deleteAll');
    Route::get('/paket/update/{id}', 'PaketController@update');
    Route::get('/claim', 'PaketController@claim')->name('claim');
    Route::get('/crm-monitor', 'PaketController@crmMonitor')->name('crm-monitor');
    Route::any('/crm-monitor/update/{id}', 'PaketController@crmMonitorUpdate')->name('crm-monitor.update');
    Route::get('/rts', 'PaketController@rts')->name('rts');

    Route::get('setting/notifikasi', 'NotifikasiController@index')->name('notifikasi');
    Route::get('setting/notifikasi/credit', 'NotifikasiController@credit')->name('notifikasi.credit');
    Route::any('setting/notifikasi/store', 'NotifikasiController@store')->name('notifikasi.store');
    Route::any('setting/notifikasi/remove', 'NotifikasiController@remove')->name('notifikasi.remove');

    Route::get('setting/apiwa', 'ApiwaController@index')->name('apiwa');
    Route::get('setting/user', 'UserController@index')->name('users');
    Route::any('setting/user/store', 'UserController@store')->name('users.store');
    Route::any('setting/user/remove', 'UserController@remove')->name('users.remove');

    Route::get('/message', 'MessageController@index')->name('message');
    Route::get('/message/delete/{id}', 'MessageController@delete')->name('message.delete');    
    Route::post('/message/delete-all', 'MessageController@deleteAll')->name('message.delete-all');
    Route::get('test', function () {
        // $wa = App\Helpers\Wa::send(1, ['phone' => '085232843165', 'message' => 'test']);
        // return $wa;
        $message = new Message();
        $message->api_id = 1;
        $message->phone = '085232843165';
        $message->message = 'test';
        $message->save();
        $notifikasijob = App\Jobs\NotifikasiJob::dispatch($message);
    });
    
    Route::get('cek-resi',function (){
        echo "ok";
        Artisan::call('idexpress:resi');
    });
    
    Route::get('cek-message',function (){
        Artisan::call('message:send');
        echo "ok";
    });

    Route::get('update-crm',function (){
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
                                echo $th->getMessage();
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
    });

    Route::get('telat',function (){
        Artisan::call('telat 7');
        echo "ok";
    });
});
