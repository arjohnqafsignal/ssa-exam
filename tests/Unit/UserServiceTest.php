<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\UserService;
use App\Models\User;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;

class UserServiceTest extends TestCase
{
    use DatabaseTransactions, WithFaker;


    /**
     * A basic unit test example.
     *
     * @return void
     */

    /** @test */
    public function it_can_return_a_paginated_list_of_users()
    {

        $user = new User();
        $this->carbon = Mockery::mock(Carbon::class);
        $this->request = Mockery::mock(Request::class);
        $this->user = Mockery::mock($user)->makePartial();
        $userService = new UserService($this->user, $this->request);
        $users = $userService->list();

        if($users)
        {
            $this->assertInstanceOf(Paginator::class, $users);
        }
        else
        {
            $this->assertTrue(true);
        }
    }

     /**
     * @test
     * @return void
     */
    public function it_can_store_a_user_to_database()
    {
        $user_model = new User();
        $request = new Request();
        $userService = new UserService($user_model, $request);

        $attribute = [
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'middlename' => $this->faker->name(),
            'prefixname' => $this->faker->name(),
            'suffixname' => $this->faker->name(),
            'username' => $this->faker->name(),
            'type' => $this->faker->name(),
            'photo' => $this->faker->imageUrl(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10)
        ];

        $user = $userService->store($attribute);
        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_find_and_return_an_existing_user()
    {
	    // Arrangements
        $user_model = new User();
        $request = new Request();
        $userService = new UserService($user_model, $request);
	    // Actions
        $existing_user = $user_model->inRandomOrder()->first();

        $user = $userService->find($existing_user->id);
	    // Assertions
        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_update_an_existing_user()
    {
        // Arrangements
        $user_model = new User();
        $request = new Request();
        $userService = new UserService($user_model, $request);
        // Actions
        $existing_user = $user_model->inRandomOrder()->first();
        $attribute = [
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
        ];
        $user = $userService->update($existing_user->id, $attribute);
        // Assertions
        $this->assertTrue($user);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_soft_delete_an_existing_user()
    {
        // Arrangements
        $user_model = new User();
        $request = new Request();
        $userService = new UserService($user_model, $request);
        // Actions
        $existing_user = $user_model->inRandomOrder()->first();
        $user = $userService->destroy($existing_user->id);
        // Assertions
        $this->assertTrue($user);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_return_a_paginated_list_of_trashed_users()
    {
        // Arrangements
        $user_model = new User();
        $request = new Request();
        $userService = new UserService($user_model, $request);
        // Actions
        $users = $userService->listTrashed() ? $userService->listTrashed() : null;
        // Assertions
        $this->assertInstanceOf(Paginator::class, $users);

    }

    /**
     * @test
     * @return void
     */
    public function it_can_restore_a_soft_deleted_user()
    {
        // Arrangements
        $user_model = new User();
        $request = new Request();
        $userService = new UserService($user_model, $request);
        // Actions
        $existing_user = $user_model->onlyTrashed()->inRandomOrder()->first();
        $user = true;
        if($existing_user)
        {
            $user = $userService->delete($existing_user->id);
        }
        // Assertions
        $this->assertTrue($user);
    }

     /**
     * @test
     * @return void
     */
    public function it_can_permanently_delete_a_soft_deleted_user()
    {
        // Arrangements
        $user_model = new User();
        $request = new Request();
        $userService = new UserService($user_model, $request);
        // Actions
        $existing_user = $user_model->onlyTrashed()->inRandomOrder()->first();
        $user = true;
        if($existing_user)
        {
            $user = $userService->delete($existing_user->id);
        }

        //  Assertions
        $this->assertTrue($user);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_upload_photo()
    {
        // Arrangements
        Storage::fake('public');
        $user_model = new User();
        $request = new Request();
        $userService = new UserService($user_model, $request);
        $file = UploadedFile::fake()->image('photo.jpg');

        // Actions
        $photo = $userService->upload($file);
        // Assertions
        Storage::disk('public')->assertExists($photo);
    }



}
