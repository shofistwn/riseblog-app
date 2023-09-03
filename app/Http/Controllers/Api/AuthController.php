<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) : JsonResponse {
        $username   = $request->input('username');
        $name   = $request->input('name');
        $email      = $request->input('email');
        $password   = $request->input('password');
        $role       = $request->input('role', '3');

        try {
            $validator  = Validator::make($request->all(), [
                'username'              => 'required|unique:users,username|min:6|max:20',
                'name'                  => 'required',
                'email'                 => 'required|email|unique:users,email',
                'password'              => 'required|confirmed|min:8|max:20',
                'password_confirmation' => 'required|min:8|max:20',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 422);
            }

            User::create([
                'username'  => $username,
                'name'      => $name,
                'email'     => $email,
                'password'  => bcrypt($password),
                'role_id'   => $role,
            ]);

            $this->message  = 'Registration successful';
        } catch (Exception $e) {
            $this->message  = $e->getMessage();
            $this->code     = $e->getCode();
        }

        return $this->createResponse($this->success, $this->message, $this->data, $this->code);
    }

    public function login(Request $request) : JsonResponse {
        $email      = $request->input('email');
        $password   = $request->input('password');

        $credentials = [
            'email'     => $email,
            'password'  => $password,
        ];

        try {
            $validator = Validator::make($request->all(), [
                'email'     => 'required|email',
                'password'  => 'required|min:8|max:20',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 422);
            }

            if (!$token = auth()->attempt($credentials)) {
                throw new Exception('Email or password is incorrect', 401);
            }

            $user = auth()->user();

            $this->message  = 'Login successful';
            $this->data     = [
                'username'  => $user->username,
                'name'      => $user->name,
                'role'      => $user->role_id,
                'token'     => $token,
            ];
        } catch (Exception $e) {
            $this->success  = false;
            $this->message  = $e->getMessage();
            $this->code     = $e->getCode();
        }

        return $this->createResponse($this->success, $this->message, $this->data, $this->code);
    }

    public function logout() : JsonResponse {
        auth()->logout();

        $this->message  = 'Logout successful';

        return $this->createResponse($this->success, $this->message, $this->data, $this->code);
    }

    public function refresh() : JsonResponse {
        $newToken = auth()->refresh();

        $this->message  = 'Token refreshed';
        $this->data     = [
            'token' => $newToken
        ];

        return $this->createResponse($this->success, $this->message, $this->data, $this->code);
    }
}
