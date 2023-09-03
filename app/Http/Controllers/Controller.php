<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $success = true;
    public $message = '';
    public $data    = [];
    public $code    = 200;

    public function createResponse($success, $message, $data, $code) : JsonResponse {
        return response()->json([
            'success'   => $success,
            'message'   => $message,
            'data'      => $data,
        ], $code);
    }
}
