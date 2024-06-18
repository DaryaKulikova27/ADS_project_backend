<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\StoreWorksRequest;
use App\Http\Requests\UpdateWorksRequest;
use App\Models\Works;


class WorksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $result = [];
        $works = Works::all();
        foreach ($works as $work) {
            $currentWorksData = [];
            $currentWorksData = [
                'work_external_id' => $work->work_external_id,
                'name' => $work->name,
                'price' => $work->price,
                'parent' => $work->parent,
                'is_folder' => $work->is_folder == 1 ? true : false
            ];

            $result['works'][] = $currentWorksData;
        }

        if (empty($result)) {
            $result = (object)$result;
        }

        return BaseController::sendResponse($result);
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
    public function store(StoreWorksRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Works $works)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Works $works)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorksRequest $request, Works $works)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Works $works)
    {
        //
    }
}
