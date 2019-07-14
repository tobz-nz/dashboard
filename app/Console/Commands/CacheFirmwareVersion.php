<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class CacheFirmwareVersion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firmware:cache-version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the latest firmware version and cache it';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client();

        $this->info(route('firmware.current'));

        $response = $client->request('GET', route('firmware.current'));
        $responseBody = json_decode($response->getBody());

        $this->info("current version: {$responseBody->current_version}");

        if ($responseBody->current_version) {
            app('cache')->forever('firmware-version', $responseBody->current_version);
        }
    }
}
