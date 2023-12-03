<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\MailWelcomeRegisteredUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeToRegisteredUser implements ShouldQueue
{

    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public ?string $connection = 'database';

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public ?string $queue = 'mail';

    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public int $delay = 10;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        Mail::to($event->registeredUser)
            ->send(new MailWelcomeRegisteredUser($event->registeredUser));
    }
}
