<?php

namespace App\Services;

use Illuminate\Http\Request;

class CaptchaService
{
    public function make(Request $request): array
    {
        $a = $request->session()->get('captcha_a', random_int(2, 9));
        $b = $request->session()->get('captcha_b', random_int(2, 9));
        $request->session()->put(['captcha_a' => $a, 'captcha_b' => $b]);

        return [$a, $b];
    }

    public function refresh(Request $request): void
    {
        $request->session()->put([
            'captcha_a' => random_int(2, 9),
            'captcha_b' => random_int(2, 9),
        ]);
    }

    public function check(Request $request, int $answer): bool
    {
        $a = (int) $request->session()->get('captcha_a', -1);
        $b = (int) $request->session()->get('captcha_b', -1);

        return $answer === $a * $b;
    }

    public function clear(Request $request): void
    {
        $request->session()->forget(['captcha_a', 'captcha_b']);
    }
}
