<?php

namespace App\Jobs;

use App\Models\Business;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PayItemSync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $payItemSync;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(\App\Services\PayItemSync $payItemSync)
    {
        $this->payItemSync = $payItemSync;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Business $business)
    {
        $this->payItemSync->payItemSyncExecute($business);
    }

    public function failed()
    {
        DB::rollBack();
    }
}
