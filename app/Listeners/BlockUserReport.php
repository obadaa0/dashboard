<?php

namespace App\Listeners;

use App\Events\ReportPostWarn;
use App\Mail\BlockUserMail;
use App\Models\report_post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class BlockUserReport
{
    public function __construct()
    {
    }
    public function handle(ReportPostWarn $event): void
    {
        $reportPost =$event->report_post;
        $reported_person = $reportPost->reportedPerson;
        $numberOfWarning = report_post::where('reported_person',$reported_person->id)
        ->where('warn',true)
        ->count();
        if($numberOfWarning > 5){
            $reported_person->update(['block' => true]);
            Mail::to($reported_person->email)->queue(new BlockUserMail($reported_person));
        }
    }
}
