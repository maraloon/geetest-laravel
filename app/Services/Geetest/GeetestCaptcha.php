<?php

namespace App\Services\Geetest;

interface GeetestCaptcha {
    public function register(): array;
    public function validate(string $challenge, string $seccode): bool;
}
