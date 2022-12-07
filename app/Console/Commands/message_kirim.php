<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Message;
use App\Helpers\Wa;

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
        $Messages = Message::where('status', 0)->get();
        foreach ($Messages as $message) {          
            if($message->phone && $message->message){
                $wa = Wa::send($message->api_id,['phone' => $message->phone, 'message' => $message->message]);
                $res = json_decode($wa);
                Message::where('id', $message->id)->update(['status' => 1,'report'=>$res->message]);          
                sleep($message->delay);
            }
        }        
    }
}
