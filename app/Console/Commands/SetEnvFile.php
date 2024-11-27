<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetEnvFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-env-file {env_file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the env_file argument
        $envFile = $this->argument('env_file');

        $this->info('Setting the .env file to ' . $envFile);

        // Create a new Request object
        $request = new \Illuminate\Http\Request();
        $request->replace(['env_file' => $envFile]);

        // Call the EnvFileController@update method
        $controller = new \App\Http\Controllers\EnvFileController();
        $controller->update($request, $envFile);

        $this->info('The .env file has been set to ' . $envFile);
    }
}
