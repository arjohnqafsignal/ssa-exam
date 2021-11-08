<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class UserFeatureTest extends TestCase
{


    use DatabaseTransactions, WithFaker;

    /**
     * @test
     * @return void
     */
    public function a_user_can_browse_user_list()
    {
        $factory = new UserFactory();
        $user = $factory->create();
        $response = $this->actingAs($user)->get('/users');
        $response->assertStatus(200);
    }

    /**
     * @test
     * @return void
     */
    public function a_user_can_create_new_user()
    {
        $factory = new UserFactory();
        $user = $factory->create();
        $password = $this->faker->password(8);
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
            'password' => $password, // password
            'password_confirmation' => $password, // password
            'remember_token' => Str::random(10),
            'photo' => UploadedFile::fake()->image('photo.jpg')
        ];
        $response = $this->actingAs($user)->post('/users' , $attribute);

        $response->assertStatus(302); //Process was redirected from controller
    }


}
