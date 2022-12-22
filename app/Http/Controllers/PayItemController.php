<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePayItemRequest;
use App\Http\Requests\UpdatePayItemRequest;
use App\Models\Business;
use App\Models\PayItem;
use App\Services\PayItemSync;
use Artisan;

class PayItemController extends Controller
{

    private $payItemSync;

    public function __construct(PayItemSync $payItemSync)
    {
        $this->payItemSync = $payItemSync;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePayItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePayItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PayItem  $payItem
     * @return \Illuminate\Http\Response
     */
    public function show(PayItem $payItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PayItem  $payItem
     * @return \Illuminate\Http\Response
     */
    public function edit(PayItem $payItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePayItemRequest  $request
     * @param  \App\Models\PayItem  $payItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePayItemRequest $request, PayItem $payItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PayItem  $payItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(PayItem $payItem)
    {
        //
    }
}
