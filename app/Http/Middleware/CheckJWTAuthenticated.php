<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenBlacklistedException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class CheckJWTAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return $this->createResponse('Token has expired');
        } catch (TokenInvalidException $e) {
            return $this->createResponse('Token is invalid');
        } catch (JWTException $e) {
            return $this->createResponse('Token not provided');
        } catch (\Exception $e) {
            return $this->createResponse('Unauthorized');
        }

        return $next($request);
    }

    private function createResponse($message)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => [],
        ], 401);
    }
}