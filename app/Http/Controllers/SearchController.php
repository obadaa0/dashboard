<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchUser(Request $request)
    {
        $search = $request->input('query');
        if (empty($search)) {
            return response()->json([
                'message' => 'يجب إدخال كلمة واحدة على الأقل',
            ], 400);
        }
        $users = User::where('role', 'police')
            ->where(function ($query) use ($search) {
                $query->where('firstname', 'LIKE', '%' . $search . '%')
                    ->orWhere('lastname', 'LIKE', '%' . $search . '%');
            })
            ->paginate(10);
        return response()->json($users);
    }
    public function searchPolice(Request $request)
    {
        $search = $request->input('query');
        if (empty($search)) {
            return response()->json([
                'message' => 'يجب إدخال كلمة واحدة على الأقل',
                'data' => [],
            ], 400);
        }
        $users = User::where('role', 'police')
            ->where(function ($query) use ($search) {
                $query->where('firstname', 'LIKE', '%' . $search . '%')
                    ->orWhere('lastname', 'LIKE', '%' . $search . '%');
            })
            ->paginate(10);
        return response()->json($users);
    }
}
