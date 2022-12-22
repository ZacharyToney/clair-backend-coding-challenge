<?php

namespace App\Console\Commands;

use App\Models\Business;
use Illuminate\Console\Command;

class PayItemSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @mixed [string,bool]
     */
    protected $signature = 'payItemSync:run {externalBusinessId} {testing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs command that sync business pay items';

    /**
     * Execute the console command.
     * @return int
     */
    public function handle()
    {
        $business = $this->argument('externalBusinessId');
        $testing = $this->argument('testing');
        $business = Business::where('external_id','=',$business)->first();
        $payItemSync = new \App\Services\PayItemSync();
        $payItemSync->payItemSyncExecute($business,$testing);
        return Command::SUCCESS;
    }
}
