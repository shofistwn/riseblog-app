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

    public function createResponse(bool $success, string $message, array $data, int $code) : JsonResponse {
        if (!is_int($code) || $code !== null) {
            $code = 200;
        }

        return response()->json([
            'success'   => $success,
            'message'   => $message,
            'data'      => $data,
        ], $code);
    }
}
