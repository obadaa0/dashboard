<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Helpers\AuthHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
 public function summarizeNews(Request $request)
    {
        $user = AuthHelper::getUserFromToken($request);
        if(!$user){
            return response()->json(['message' => 'قم بتسجيل الدخول اولا'],401);
        }

        // Carbon::setWeekStartsAt(Carbon::SATURDAY);
        // Carbon::setWeekEndsAt(Carbon::FRIDAY);
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $posts = Post::whereBetween('created_at', [$startOfWeek, $endOfWeek])
    ->whereHas('user', function ($query) {
        $query->where('role', 'police');
    })
    ->pluck('content');
    $postArray = $posts->toArray();
$response = Http::post('https://19f5-212-102-51-98.ngrok-free.app/summarize', [
    'texts' => $postArray
]);
    if($response->successful())
    {
        $news = Post::create([
            'user_id' => $user->id,
            'content' => json_encode($response['summaries']),
            'isNews' => true
        ]);
        return response()->json(['data' => $response['summaries']]);
    }else{
             return  $news = Post::create([
            'user_id' => $user->id,
            'content' => json_encode($postArray),
            'isNews' => 1
        ]);
    }
    return $response->json();
    }
}
