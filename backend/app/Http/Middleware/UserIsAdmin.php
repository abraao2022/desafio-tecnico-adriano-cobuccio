<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->admin) {
            return response()->json([
                'success' => false,
                'message' => 'Acesso não autorizado. Apenas administradores podem acessar esta rota.',
            ], 403);
        }

        return $next($request);
    }
}
