<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Stats extends Mailable
{
    use Queueable, SerializesModels;

    public $artist_num;
    public $album_num;
    public $milliseconds;

    /**
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("Here are the music-app stats!")
            ->view('stats.stats');
    }
}
