<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 1000; $i++) {
            $gender = null;
            if (mt_rand(0, 1)) {
                $gender = 'male';
            } else {
                $gender = 'female';
            }
            DB::table('users_info')->insert([
                'status' => 'Test status number ' . ($i+1),
                'gender' => $gender,
            ]);
        }
    }
}
