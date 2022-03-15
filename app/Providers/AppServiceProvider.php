<?php

namespace App\Providers;

use App\Services\Geetest\GeetestCaptcha;
use App\Services\Geetest\GeetestOnlineCaptcha;
use App\Services\Geetest\FallbackCaptcha;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Redis;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(GeetestCaptcha::class, function($app) {
            return Redis::get(config('geetest.is_api_available_redis_key'))
                ? new GeetestOnlineCaptcha()
                : new FallbackCaptcha(); 
        });
    }

    public function register()
    {
        //
    }
}
