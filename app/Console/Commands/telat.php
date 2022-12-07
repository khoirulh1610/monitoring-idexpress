<?php

namespace App\Console\Commands;

use App\Helpers\Wa;
use App\Models\Apiwa;
use App\Models\Notifikasi;
use App\Models\Paket;
use Illuminate\Console\Command;

class telat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telat {overdue}';

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
        $overdue = $this->argument('overdue');
        $paket = Paket::where('operationType','<>', 10)->where('overdue','>',$overdue)->get();
        $temp_notif = Notifikasi::where('name', 'on_proses_7')->first();
        foreach ($paket as $p) {
            $this->info($p->waybill_no);
            $api = Apiwa::where('status', 1)->inRandomOrder()->first();
            if($api){
                $message = Wa::ReplaceArray($p, $temp_notif->copywriting);                
                $tujuan = explode(',', $temp_notif->target_notif);
                foreach ($tujuan as $t) {
                    $wa = Wa::send($api->id,['phone' => $t, 'message' => $message]);
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
                        Apiwa::where('id', $api->id)->update(['status' => 0]);
                    }
                    $this->info($wa);
                }                
            }
        }
    }
}
