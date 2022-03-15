<?php

namespace App\Services\Geetest;

use Illuminate\Support\Str;

class FallbackCaptcha implements GeetestCaptcha {

    public function register(): array
    {
        return [
            "offline" => true,
            "gt" => config('geetest.id'), 
            "challenge" => Str::of(Str::random(32))->lower(),
        ];
    }

    public function validate($challenge, $seccode): bool
    {
        return $challenge && $seccode;
    }
}
