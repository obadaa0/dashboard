<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Helpers\AuthHelper;
use App\Models\News;
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
    $newsText = '';
    foreach($postArray as $postt){
        $newsText .= $postt;
    }
        // return $news;
$response = Http::post('https://19f5-212-102-51-98.ngrok-free.app/summarize', [
    'texts' => $postArray
]);
    if($response->successful())
    {
        // $news = News::create([
        //     'news' => array_values($posts->toArray()),
        //     'user_id' => $user->id
        // ]);
        return response()->json(['data' => $response['summaries']]);
    }
    return $response->json();
    }
}
