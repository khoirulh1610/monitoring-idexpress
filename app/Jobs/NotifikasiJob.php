<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use App\Helpers\Wa;
use Illuminate\Support\Facades\Log;

class NotifikasiJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $message;
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = $this->message;
        if($message->phone && $message->message){
            $wa = Wa::send($message->api_id,['phone' => $message->phone, 'message' => $message->message]);
            $res = json_decode($wa);
            Message::where('id', $message->id)->update(['status' => 1,'report'=>$res->message]);
            Log::info($wa);
        }
    }
}
