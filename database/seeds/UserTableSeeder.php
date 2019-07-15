<?php

use Illuminate\Database\Seeder;
use App\User;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'name'				=> 'clinic',
        	'email'				=> 'clinic@zapport.com',
        	'password'			=> Hash::make('43214321'),
        	'remember_token'	=> str_random(10)
        ]);
    }
}
