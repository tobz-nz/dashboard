<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Toby Evans',
            'email' => 'tobz.nz@gmail.com',
            'password' => Hash::make('asdasdasd'),
            'email_verified_at' => new Carbon,
            'api_token' => Str::random(60),
        ])->each(function ($user) {
            // $user->assignRole('super');
        });
    }
}
