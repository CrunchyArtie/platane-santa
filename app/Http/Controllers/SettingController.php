<?php

namespace App\Http\Controllers;

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
        return view('settings', [
            'settings' => Setting::all(),
        ]);
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
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'value' => 'required|string',
        ]);

        $setting = Setting::create($request->all());

        return redirect()->route('settings.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        throw new \Exception('Not implemented');
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
        $request->validate([
            'value' => 'required|string',
        ]);

        $setting->update($request->all());

        return redirect()->route('settings.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();

        return redirect()->route('settings.index');
    }
}
