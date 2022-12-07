<?php

namespace App\Console\Commands;

use App\Helpers\Wa;
use App\Models\Apiwa;
use Illuminate\Console\Command;

class wa_status extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wa:status';

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
        $apiwa = Apiwa::where('name', 'Tokalink')->get();
        foreach ($apiwa as $api) {
            if($api->name=='Tokalink'){
                $this->info(Wa::TokalinkStatus($api->id));
            }
        }
    }
}
