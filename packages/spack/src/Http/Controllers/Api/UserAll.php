<?php

namespace Spack\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAll
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'limit' => 'nullable|integer|min:0',
        ]);

        $users = DB::table('users')
            ->select('id', 'name', 'email', 'avatar');

        if ($limit = $request->limit) {
            $users->limit($limit);
        }

        return $users
            ->where('tenant_id', session('tenant_id'))
            ->get();
    }
}
