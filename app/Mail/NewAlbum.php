<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Album;

class NewAlbum extends Mailable
{
    use Queueable, SerializesModels;

    // In php, properties are protected by default. So, this way any public property we declare will be accessible to a view
    public $album;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Album $album)
    {
        $this->album = $album;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("{$this->album->artist->name} has a new album!") // Can pick off the album we passed in through constructor and b/c we're using eloquent, we can reach for artist relationship and grab the name
            ->view('email.new-album');
    }
}
