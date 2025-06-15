<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchUser(Request $request)
    {
        $search = $request->input('query');
        if (empty($search)) {
            return response()->json([
                'message' => 'يجب ادخال كلمة واحدة على الاقل',
                'users' => [],
            ], 400);
        }
        $users = User::where('firstname', 'LIKE', '%' . $search . '%')
            ->where('role', 'user')
            ->orWhere('lastname', 'LIKE', '%' . $search . '%')
            ->limit(10)
            ->get();
        if ($users->isEmpty()) {
            return response()->json([
                'message' => 'لا يوجد نتائج',
            ]);
        }
        return response()->json([
            'message' => 'Search results',
            'users' => $users,
        ]);
    }
    public function searchPolice(Request $request)
    {
        $search = $request->input('query');
        if (empty($search)) {
            return response()->json([
                'message' => 'يجب ادخال كلمة واحدة على الاقل',
                'users' => [],
            ], 400);
        }
        $users = User::where('firstname', 'LIKE', '%' . $search . '%')
            ->where('role', 'police')
            ->orWhere('lastname', 'LIKE', '%' . $search . '%')
            ->limit(10)
            ->get();
        if ($users->isEmpty()) {
            return response()->json([
                'message' => 'لا يوجد نتائج',
            ]);
        }
        return response()->json([
            'message' => 'Search results',
            'users' => $users,
        ]);
    }
}
