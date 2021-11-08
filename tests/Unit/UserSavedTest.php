<?php

namespace Tests\Unit;

use App\Events\UserSaved;
use App\Listeners\SaveUserBackgroundInformation;
use App\Models\User;
use App\Services\UserService;
use Database\Factories\UserFactory;
use Illuminate\Http\Testing\File;
use Mockery;
use Tests\TestCase;
use Illuminate\Http\Request;

class UserSavedTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function it_can_listen_to_userSaved_event()
    {
        $factory = new UserFactory();
        $user = $factory->create();
        $this->request = Mockery::mock(Request::class);
        $this->user = Mockery::mock($user)->makePartial();
        $userService = new UserService($this->user, $this->request);
        $listener = new SaveUserBackgroundInformation($userService);

        $result = $listener->handle(new UserSaved($this->user));
        $this->assertTrue($result);
    }
}
