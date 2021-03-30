<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\Stats;
use App\Models\User;
use Exception;

class DisplayStats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $artist_num;
    protected $album_num;
    protected $milliseconds;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($artist_num,$album_num,$milliseconds)
    {
        $this->artist_num = $artist_num;
        $this->album_num = $album_num;
        $this->milliseconds = $milliseconds;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::all();

        foreach ($users as $user){
            if ($user->email){
                Mail::to($user->email)->send(new Stats($this->artist_num,$this->album_num,$this->milliseconds));
            } else {
                throw new Exception("User {$user->id} is missing an email");
            }
           
        }
    }
}
