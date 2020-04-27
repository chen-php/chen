<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Session;

class CodeController extends Controller
{
    public function captcha()
    {
        $builder = new CaptchaBuilder();
        $builder->build($width = 120, $height = 40,$font = null);
        $phrase = $builder->getPhrase();
        Session::flash("checkcode", $phrase);
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type: image/jpeg");
        return $builder->output();
    }
}
