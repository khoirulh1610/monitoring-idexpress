<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Message;
use App\Helpers\Wa;
use App\Models\Apiwa;
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
        $cek_jeda = Message::where('status', 1)->orderBy('next_run_at','desc')->first();
        if($cek_jeda){
            $this->info($cek_jeda->next_run_at);
            if($cek_jeda->next_run_at > date('Y-m-d H:i:s')){
                exit;
            }
        }
        Log::info('message:send runing at '.date('Y-m-d H:i:s'));
        $Messages = Message::where('status', 0)->get();
        foreach ($Messages as $message) {     
            $api = Apiwa::where('status', 1)->inRandomOrder()->first();
            if($api){
                if($message->phone && $message->message){
                    $wa = Wa::send($api->id,['phone' => $message->phone, 'message' => $message->message]);
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
                        Apiwa::where('id', $api->id)->update(['status' => 0]);
                    }
                    Message::where('id', $message->id)->update(['status' => $status,'report'=>$res->message,'api_id'=>$api->id,'next_run_at'=>date('Y-m-d H:i:s', strtotime('+'.($message->delay+60).' seconds'))]);          
                    sleep($message->delay);
                }
            }
        }   
        exit;     
    }
}
