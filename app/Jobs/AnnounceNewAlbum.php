<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Album;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewAlbum;
use App\Models\User;
use Exception;

class AnnounceNewAlbum implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $album;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Album $album)
    {
        $this->album = $album; //passed in data through web.php mail route - dispatch method on AnnounceNewAlbum jobs class.
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() //automatically called by Laravel
    {
        $users = User::all();

        foreach($users as $user) {
            // Use ->send instead of ->queue because dispatch method in job already creates entry in jobs table. Don't need to have a job that creates more jobs. We just need to have 1 job that goes ahead and sends the emails.

            if ($user->email) {
                Mail::to($user->email)->send(new NewAlbum($this->album));
            }
            else {
                throw new Exception("User {$user->id} is missing an email.");
            }
        }
    }
}
