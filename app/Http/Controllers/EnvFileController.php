<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnvFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // List all the .env files
        $envFiles = glob(base_path('.env*'));
        $envFiles = array_map('basename', $envFiles);

        // Remove the .env file from the list
        $envFiles = array_filter($envFiles, function ($file) {
            return $file !== '.env';
        });

        // Sort the files
        sort($envFiles);

        // find the current .env file between each file in the list
        $currentEnvFile = basename(readlink(base_path('.env')));

        return view('env-files', compact('envFiles', 'currentEnvFile'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Switch the .env file to the one selected
        $this->validate($request, [
            'env_file' => 'required|string'
        ]);

        // Check if the file exists
        $envFile = base_path($request->env_file);
        if (!file_exists($envFile)) {
            return back()->with('error', 'The selected .env file does not exist.');
        }

        // remove the .env file if it exists
        if (file_exists(base_path('.env'))) {
            unlink(base_path('.env'));
        }

        // create a symlink to the selected .env file
        symlink($envFile, base_path('.env'));

        return back()->with('success', 'The .env file has been switched successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
