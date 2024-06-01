<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\StoreWorksInOrderRequest;
use App\Http\Requests\UpdateWorksInOrderRequest;
use App\Models\WorksInOrder;

class WorksInOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorksInOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WorksInOrder $worksInOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorksInOrder $worksInOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorksInOrderRequest $request, WorksInOrder $worksInOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorksInOrder $worksInOrder)
    {
        //
    }
}
