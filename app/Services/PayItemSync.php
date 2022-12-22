<?php

namespace App\Services;

use App\Models\Business;
use App\Models\PayItem;
use App\Models\User;
use DB;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Log;

class PayItemSync
{
    /**
     * @throws \Throwable
     */
    public function payItemSyncExecute(Business $business,$testing = false): void
    {
        try {
            if ($business->enabled){
                DB::beginTransaction();
                $this->getDataFromApi($business->external_id,1,$testing);
                DB::commit();
            }
        }
        catch (Exception|\Throwable $e){
            DB::rollBack();
            throw new Exception("Failed Job");
        }
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    private function getDataFromApi(string $businessExternalId, int $page,bool $testing): void
    {
        $headers = [
            'Content-Type' => 'application/json',
            'x-api-key' => env('API_KEY_PAY_ITEM_SYNC'),
        ];

        $guzzle = new Client(['headers'=>$headers]);
        $partnerWebsite = env('PARTNER_WEBSITE');
        try {

            $url = "https://$partnerWebsite/clair-pay-item-sync/$businessExternalId";

            if ($testing){
                if ($page === 1){
                    $resultsFromPayItemApi = $this->firstPageFakeApi();
                }
                else{
                    $resultsFromPayItemApi = $this->secondPageFakeApi();
                }
            }
            else{
                $resultsFromPayItemApi = $guzzle->get($url,[
                    'query'=>['page'=>$page]
                ]);
                $resultsFromPayItemApi = json_decode($resultsFromPayItemApi->getBody()->getContents(),true);
            }


            foreach ($resultsFromPayItemApi as $apiKey=>$apiValue){
                if ($apiKey === 'payItems'){
                    //loop through pay items
                    foreach ($apiValue as $payItem){
                        $this->processPayItem($payItem,$businessExternalId);
                    }

                }
                if($apiKey === 'isLastPage'){
                    if(!$apiValue){
                        $page++;
                        $this->getDataFromApi($businessExternalId,$page,$testing);
                    }
                }
            }

        }catch (GuzzleException $e){
            if($e->getCode() === 404 ){
                Log::critical($e->getMessage());
                throw new Exception("No businesses exist with pay item api.");
            }
            elseif ($e->getCode() === 401){
                Log::alert($e->getMessage());
                throw new Exception("Failed to authenticate with pay item api.");
            }
        }
    }

    private function processPayItem($payItem,$businessExternalId): void
    {
        $usersWithEmployeeID = User::where('external_id','=',$payItem->employeeId)->get();
        if ($usersWithEmployeeID->count() > 0){
            $deduction = Business::where('external_id','=',$businessExternalId)->first()->deduction;
            if ($deduction === null){
                $deduction = 30;
            }

            $amount = $payItem->hoursWorked * $payItem->payRate * ($deduction * 0.01);
            $amountRounded = round($amount,2);
            PayItem::updateOrCreate([
                'external_id'=>$payItem->id
            ],[
                'amount'=>$amountRounded,
                'hours_worked'=>$payItem->hoursWorked,
                'pay_rate'=>$payItem->payRate,
                'date'=>$payItem->date,
                'external_id'=>$payItem->id,
            ]);
        }

    }

    private function firstPageFakeApi()
    {
        $jsonString = '
    {
      "payItems": [
        {
          "id": "anExternalIdForFirstPayItem",
          "employeeId": "firstEmployeeId",
          "hoursWorked": 11.5,
          "payRate": 11.5,
          "date": "2021-10-19"
        }
      ],
      "isLastPage": false
}
    ';
        return json_decode($jsonString);
    }

    private function secondPageFakeApi()
    {
        $jsonString = '
    {
          "payItems": [
            {
              "id": "anExternalIdForSecondPayItem",
              "employeeId": "secondEmployeeId",
              "hoursWorked": 8.5,
              "payRate": 12.5,
              "date": "2021-10-19"
            },
            {
              "id": "anExternalIdForThirdPayItem",
              "employeeId": "thirdEmployeeId",
              "hoursWorked": 10,
              "payRate": 8,
              "date": "2021-10-18"
            }
          ],
          "isLastPage": true
        }
    ';
        return json_decode($jsonString);
    }
}
