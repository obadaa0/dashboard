<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Helpers\AuthHelper;
use App\Helpers\MediaHelper;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'content' => 'required|string',
                'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi',
            ]);
            $path = MediaHelper::StoreMedia('posts',$request,'media');
            $user = AuthHelper::getUserFromToken($request);
            if(!$user){
                return response()->json([
                    'message' => 'user not found !'
                ]);
            }
        //     try{
        //         $response = Http::timeout(100)->post('https://2512-185-184-195-145.ngrok-free.app/predict',[
        //             'text' => $validatedData['content']
        //         ]);
        //         if($response->successful())
        //         {
        //             if($response['prediction'] != "real"){
        //                 return response()->json(['message' => ' text is fake'],400);
        //             }
        //         }
        //     }
        //       catch(Exception $e){
        //     return response()->json(['error' => $e->getMessage()]);
        // }
        // catch(ConnectionException $e)
        // {
        //     return response()->json(['error' => $e->getMessage()]);
        // }
        // catch(RequestException $e){
        //     return response()->json(['error' => $e->getMessage()]);
        // };
            $post=Post::create([
                'user_id' =>$user->id,
                'content' => $request['content'],
                'media' => $path
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Post created successfully',
                'data' => $post
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create post',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function delete(Request $request,Post $post)
    {
      $user = AuthHelper::getUserFromToken($request);

        if(!$user){
            return response()->json([
                'message' => 'user not found !'
            ]);
        }
        if(!$post){
            return response()->json([
                'message' => 'post not found !'
            ],404);
        }
        $post=$post
        ->where('user_id',$user->id)
        ->where('id',$post->id);
        if(!$post)
        {
            return response()->json([
                'message' => 'post not found !'
            ],404);
        }
        if($post->delete()){
            return response()->json([
                'mesasge' => 'post deleted'
            ],200);
        }
        return response()->json([
            'message' => ' Error'
        ],501);
    }
    public function getPosts(Request $request)
    {
     $user = AuthHelper::getUserFromToken($request);

        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }
        $posts=$user->posts;
        if(!$posts)
        {
            return response()->json(['message' => "can't find any post"],200);
        }
        foreach($posts as $post)
        {
            $hasLiked = $post->reactions()
            ->where('reaction_type', 'like')
            ->where('user_id', $user->id)
            ->exists();
            $post->has_liked = $hasLiked;
            $post->loadCount([
                'reactions as likes' => function ($q) {
                    $q->where('reaction_type', 'like');
                }
            ]);
            $post->loadCount([
                'comment as comments'
            ]);
            $post['user_name'] = $user->firstname.' '.$user->lastname;
            $post['profile_image'] = $user->profile_image;
            if($post->media == null)
            {
                $post->media = "";
            }
        }
        return response()->json(['message' => 'Successfully response','data'=>
        [
        'posts' => $posts
        ] ],200);
    }

    public function getAllPost(Request $request)
    {
     $user = AuthHelper::getUserFromToken($request);

        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }
        $posts=Post::inRandomOrder()->get();
        if(!$posts)
        {
            return response()->json(['message' => "can't find any post"],204);
        }
        $userPost = [];
        $otherPost = [];
        $filterPost = [];
        foreach($posts as $post)
        {
        $isFriend = Friend::where([
        ['user_id', $user->id],
        ['friend_id', $post->user_id],
    ])->orWhere([
        ['user_id', $post->user_id],
        ['friend_id', $user->id],
    ])->exists();
    $post['is_friend'] = $isFriend;
            if($post->user_id == $user->id)
            {
                if($post->created_at->isToday())
                {
                    $post['his_post'] = true;
                    $hasLiked = $post->reactions()
                ->where('reaction_type', 'like')
                ->where('user_id', $user->id)
                ->exists();
                $post->has_liked = $hasLiked;
                $post->loadCount([
                    'reactions as likes'
            ]);
            $post->loadCount([
                'comment as comments'
            ]);
            $post['user_name'] = $user->firstname . ' ' . $user->lastname;
            $post['profile_image'] = $user->profile_image;
                    $userPost[] =$post;
                }
                continue;
            }
            $hasLiked = $post->reactions()
            ->where('reaction_type', 'like')
            ->where('user_id', $user->id)
            ->exists();
            $post->has_liked = $hasLiked;
            $post->loadCount([
                'reactions as likes'
            ]);
            $post->loadCount([
                'comment as comments'
            ]);
            $post['user_name'] = $post->User->firstname . ' ' . $post->User->lastname;
            $post['profile_image'] = $post->user->profile_image;
            $otherPost[] = $post;
        }
        $filterPost =array_merge($userPost,$otherPost);
        return response()->json(['message' => 'Successfully response','data'=>
        [
        'posts' => $filterPost
        ] ],200);
    }
public function showPost(Post $post) {
    $post->loadCount('reactions as likes')
        ->loadCount('comment as comments');
    $post['user_name'] = $post->User->firstname . " " . $post->User->lastname;
    $post->setRelation('user', null);
    return response()->json(['data' => [$post]]);
}

    public function summarizeNews()
    {
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
$response = Http::post('https://153e-185-184-195-145.ngrok-free.app/summarize', [
    'texts' => $postArray
]);
    if($response->successful())
    {
        return response()->json(['data' => $response['summaries']]);
    }
    return $response->json();
    }
}
