<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Message;
use App\Helpers\Wa;
use App\Models\Apiwa;
use App\Models\LogCommand;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class message_kirim extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:send';

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
        $logcom = LogCommand::where('command','message:send')->first();
        // if($logcom){
        //     if($logcom->next_run_at){
        //         if($logcom->next_run_at > Carbon::now()){
        //             exit;
        //         }
        //     }
        // }
        
        
        $cek_jeda = Message::where('status', 1)->orderBy('next_run_at','desc')->first();
        if($cek_jeda){
            $this->info($cek_jeda->next_run_at);
            if($cek_jeda->next_run_at > date('Y-m-d H:i:s')){
                exit;
            }
        }
        // Log::info('message:send runing at '.date('Y-m-d H:i:s'));
        $Messages = Message::where('status', 0)->get();
        foreach ($Messages as $message) {     
            
            $last_msg = Message::where('phone', $message->phone)->whereNotNull('api_id')->orderBy('id','desc')->first();
            $api_id = $last_msg->api_id ?? '';
            if(!$last_msg){
                $api = Apiwa::where('status', 1)->inRandomOrder()->first();
                $api_id = $api->id ?? '';
            }
            if($api_id){
                if($message->phone && $message->message){
                    $wa = Wa::send($api_id,['phone' => $message->phone, 'message' => $message->message]);
                    $res = json_decode($wa);
                    $status = 0;
                    if($res->message=='Terkirim'){
                        $status = 1;
                    }elseif ('Belum Terdafar') {
                        $status = 2;
                    }else{
                        $status = 3;
                    }
                    if($res->message=='device offline'){
                        $status = 0;
                        Apiwa::where('id', $api_id)->update(['status' => 0]);
                    }
                    Message::where('id', $message->id)->update(['status' => $status,'report'=>$res->message,'api_id'=>$api_id,'next_run_at'=>date('Y-m-d H:i:s', strtotime('+'.($message->delay+60).' seconds'))]);          
                    sleep($message->delay);
                }
            }
        }   
        $logcom->next_run_at = Carbon::now()->addMinute($logcom->delay);
        $logcom->save();
    }
}
