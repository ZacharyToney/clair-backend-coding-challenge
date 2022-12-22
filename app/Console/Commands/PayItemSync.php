<?php

namespace App\Console\Commands;

use App\Models\Business;
use Illuminate\Console\Command;

class PayItemSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payItemSync:run {externalBusinessId}';

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
        $business = Business::where('external_id','=',$business)->first();
        $payItemSync = new \App\Services\PayItemSync();
        $payItemSync->payItemSyncExecute($business);
        return Command::SUCCESS;
    }
}
