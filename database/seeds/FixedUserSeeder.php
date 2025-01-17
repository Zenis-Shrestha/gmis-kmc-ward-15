<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FixedUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'API',
            'email' => 'api_user@gmail.com',
            'password' => bcrypt('Api_user@123'), 
            'api_token' => Str::random(60),  
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
