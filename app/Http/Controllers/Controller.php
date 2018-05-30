<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function output($code = 200, $message = "", $data = [], $jsonp = '')
    {
        $res = [
            "meta" => [
                "code"    => $code,
                "message" => $message,
            ],
            "data" => $data,
        ];
        if (!$jsonp) {
            return response()->json($res);
        }
        return response()->json($res)->setCallback($jsonp);
    }
}
