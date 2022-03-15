<?php

namespace App\Services\Geetest;

use Illuminate\Support\Facades\Http;

class GeetestOnlineCaptcha implements GeetestCaptcha {

    public function register(): array
    {
        $originChallenge = $this->requestRegister();

        $challenge = hash_hmac('sha256', $originChallenge, config('geetest.key'));

        return [
            "offline" => false,
            "gt" => config('geetest.id'),
            "challenge" => $challenge,
        ];
    }

    private function requestRegister(): string
    {
        $registerUrl = config('geetest.api_endpoint') . '/register.php';

        $response = Http::get($registerUrl, [
            "user_id" => 'test', // todo писать id пользователя, который хочет авторизоваться
            "client_type" => "web",
            /* "ip_address" => "127.0.0.1", */ // если на проде можно не указывать, то лучше не указывать. В доках про это ничего нет
            "gt" => config('geetest.id'),
            "sdk" => config('geetest.sdk_version'),
            "json_format" => 1,
            "digestmod" => 'hmac-sha256',
        ]);

        return $response->successful()
            ? $response->json('challenge')
            : '';
    }

    public function validate($challenge, $seccode): bool
    {
        if (!($challenge && $seccode)){
            return false;
        }

        $responseSeccode = $this->requestValidate($challenge, $seccode);

        return $responseSeccode && $responseSeccode !== 'false';
    }

    private function requestValidate($challenge, $seccode): string
    {
        $validateUrl = config('geetest.api_endpoint') . '/validate.php';

        $response = Http::post($validateUrl, [
            "seccode" => $seccode,
            "json_format" => 1, 
            "challenge" => $challenge,
            "sdk" => config('geetest.sdk_version'),
            "captchaid" => config('geetest.id')
        ]);

        return $response->successful()
            ? $response->json('seccode')
            : '';
    }
}
