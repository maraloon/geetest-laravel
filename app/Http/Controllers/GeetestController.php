<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Geetest\GeetestCaptcha;

class GeetestController extends Controller
{

    public function register(Request $request, GeetestCaptcha $geetest)
    {
        $result = $geetest->register();

        return response()->json($result);
    }

    public function validateCaptcha(Request $request, GeetestCaptcha $geetest)
    {
        return response()->json(['result' => true]);
        $result = $geetest->validate(
            $request->post('geetest_challenge'),
            $request->post('geetest_seccode')
        );

        return response()->json(['result' => $result]);
    }

}
