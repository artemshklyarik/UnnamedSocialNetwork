<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 1000; $i++) {
            DB::table('users')->insert([
                'name' => str_random(10),
                'email' => 'testuser' . $i . '@mail.com',
                'password' => bcrypt('12345678'),
            ]);
        }
    }
}
