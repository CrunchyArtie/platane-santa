<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ParametersInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parameters-init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize the parameters table with default values';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Initializing parameters table...');

        $this->call('db:seed', [
            '--force' => true,
            '--class' => 'ParametersTableSeeder',
        ]);

        $this->info('Parameters table initialized.');
    }
}
