<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class CheckGeetestApiAvailability extends Command
{
    protected $signature = 'geetest:available';
    protected $description = 'Check if geetest api is available';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $url = config('geetest.bypass_endpoint');
        $params = ["gt" => config('geetest.id')];

        try {
            $response = Http::get($url, $params);

            $available = $response->json('status') === 'success';
        } catch (\Throwable $t) {
            $available = false;
        }

        Redis::set(config('geetest.is_api_available_redis_key'), $available);

        return 0;
    }
}
