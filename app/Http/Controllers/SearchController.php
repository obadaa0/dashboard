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
    $search = $_GET['query'];
    // if(!isset($search)){
    //     return
    // }

    if(empty($search)) {
        return response()->json([
            'message' => 'Search word is required',
            'users' => [],
            'posts' => []
        ], 400);
    }
    $posts = Post::where('content', 'LIKE', '%'.$search.'%')
                ->limit(20)
                ->get();
    $users = User::where('firstname', 'LIKE', '%'.$search.'%')
                ->orWhere('lastname', 'LIKE', '%'.$search.'%')
                ->limit(10)
                ->get();
    return response()->json([
        'message' => 'Search results',
        'users' => $users,
        'posts' => $posts
    ]);
}
}
