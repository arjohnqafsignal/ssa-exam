<?php

namespace App\Listeners;

use App\Events\UserSaved;
use App\Services\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveUserBackgroundInformation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the event.
     *
     * @param  UserSaved  $event
     * @return bool
     */
    public function handle(UserSaved $event)
    {
        return $this->userService->saveUserDetails($event->user);
    }
}
