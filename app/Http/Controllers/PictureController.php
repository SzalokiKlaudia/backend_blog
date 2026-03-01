<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Http\Requests\StorePictureRequest;
use App\Http\Requests\UpdatePictureRequest;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePictureRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Picture $picture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePictureRequest $request, Picture $picture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Picture $picture)
    {
        //
    }
}
