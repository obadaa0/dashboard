<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
public function search(Request $request)
{
    $search = $request->input('query');
    if (empty($search)) {
        return response()->json([
            'message' => 'Search word is required',
            'users' => [],
        ], 400);
    }
    $users = User::where('firstname', 'LIKE', '%'.$search.'%')
                ->where('role',['user','police'])
                ->orWhere('lastname', 'LIKE', '%'.$search.'%')
                ->limit(10)
                ->get();
                if($users->isEmpty()){
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
