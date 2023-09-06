<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function profile(string $username) : JsonResponse {
        try {
            $user = User::where('username', $username)->first();

            if (!$user) {
            throw new Exception('User not found', 404);
            }

            $this->message = 'User profile';
            $this->data    = $user;
        } catch (Exception $e) {
            $this->success = false;
            $this->message = $e->getMessage();
            $this->code    = $e->getCode();
        }

        return $this->createResponse($this->success, $this->message, $this->data, $this->code);
    }
}
