<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    public function show(Request $request)
    {
        // Jika ada package Mews\Captcha, gunakan ini:
        if (class_exists('Mews\\Captcha\\Captcha')) {
            return app('captcha')->create('default');
        }

        // Jika tidak ada, generate captcha sederhana (huruf+angka) pakai GD
        $code = '';
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        for ($i = 0; $i < 6; $i++) {
            $code .= $chars[rand(0, strlen($chars) - 1)];
        }
        session(['captcha_code' => $code]);

        $img = imagecreatetruecolor(180, 44);
        $bg = imagecolorallocate($img, 255, 255, 255);
        imagefilledrectangle($img, 0, 0, 180, 44, $bg);

        $font = base_path('resources/fonts/ARIALBD.TTF');
        $fontSize = 22;
        $captchaColor = imagecolorallocate($img, 107, 114, 128); // abu-abu Tailwind #6B7280

        // Garis noise warna abu-abu
        for ($i = 0; $i < 8; $i++) {
            imageline($img, mt_rand(0, 180), mt_rand(0, 44), mt_rand(0, 180), mt_rand(0, 44), $captchaColor);
        }

        // Karakter captcha
        for ($i = 0; $i < strlen($code); $i++) {
            $angle = mt_rand(-15, 15);
            $x = 10 + $i * 28;
            $y = rand(30, 38);
            imagettftext($img, $fontSize, $angle, $x, $y, $captchaColor, $font, $code[$i]);
        }

        ob_start();
        imagepng($img);
        $image_data = ob_get_clean();
        imagedestroy($img);
        return response($image_data)->header('Content-Type', 'image/png');
    }
} 