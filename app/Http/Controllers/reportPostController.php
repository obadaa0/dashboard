<?php

namespace App\Http\Controllers;

use App\Events\ReportPostWarn;
use App\Helpers\AuthHelper;
use App\Mail\WarnUser;
use App\Models\Post;
use App\Models\report_post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class reportPostController extends Controller
{
    public function show()
    {
            $reports = report_post::with([
        'post',
        'reporter' => function($query) {
            $query->select('id', 'firstname', 'lastname');
        },
        'reportedPerson' => function($query){
            $query->select('id','firstname','lastname');
        }
    ])->paginate(10);
        if($reports->isEmpty()){
            return response()->json(['message' => "No report find"],200);
        }
        return $reports;
    }
    public function makeReviewed(report_post $report_post){
        return $report_post->makeReviewed();
    }
    public function makeRejected(report_post $report_post){
        return $report_post->makeRejected();
    }
    public function warnUser(report_post $report_post){
        if(!$report_post){
            return response()->json(['message' => 'no report found !'],404);
        }
        $report_post->AddWarn();
        $reported_person = $report_post->reportedPerson;
        $reporter = $report_post->reporter;
        $post = $report_post->post;
        event(new ReportPostWarn($report_post));
           Mail::to($reported_person->email)->queue(new WarnUser($reporter,$reported_person,$post));
        return response()->json(['message' => 'Send warning successfully'],200);
    }
}
