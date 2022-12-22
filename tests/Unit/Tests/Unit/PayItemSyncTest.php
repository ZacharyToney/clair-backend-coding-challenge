<?php

namespace Tests\Unit;

use App\Models\Business;
use App\Models\PayItem;
use App\Models\User;
use Tests\TestCase;

class PayItemSyncTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        if(env('APP_ENV') == 'testing'){
            Business::truncate();
            User::truncate();
            PayItem::truncate();
            Business::create([
                'name' => "Business Name #1",
                'external_id' => "business_external_id_1",
                'enabled' => true,
                'deduction' => 40,
            ]);
            Business::create([
                'name' => "Business Name #2",
                'external_id' => "business_external_id_2",
                'enabled' => true,
            ]);
            Business::create([
                'name' => "Business Name #3",
                'external_id' => "business_external_id_3",
                'enabled' => false,
            ]);
            User::create([
                'name' => "Zachary Toney",
                'email' => "zach@clearseries.com",
                'password' => \Hash::make("somepassword"),
                'external_id' => "firstEmployeeId"
            ]);
            \Artisan::queue('payItemSync:run',['externalBusinessId'=>'business_external_id_1','testing'=>true]);
        }
    }

    public function test_that_true_is_true()
    {
        $this->assertTrue(true);
    }

    public function test_db_setup()
    {
        $this->assertTrue(Business::get()->count() === 3);
        $this->assertTrue(User::get()->count() === 1);
    }
    public function test_first_pay_item_inserted()
    {
        $payItem = PayItem::where('external_id','=','anExternalIdForFirstPayItem');
        $this->assertTrue($payItem->count() === 1);
    }
}
