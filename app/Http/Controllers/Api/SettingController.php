<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Setting::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        throw new \Exception('Not implemented');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request  $request)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        return $setting;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        throw new \Exception('Not implemented');
    }
}
