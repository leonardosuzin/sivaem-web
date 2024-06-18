<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    public function handle(Request $request, Closure $next, ...$types)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $allowed = false;

        foreach ($types as $type) {
            if ($user->tipo_user == $type) {
                $allowed = true;
                break;
            }
        }

        if ($allowed) {
            return $next($request);
        }

        return response()->json(['error' => 'Forbidden'], 403);
    }
}
