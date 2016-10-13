<?php

use Illuminate\Database\Seeder;

class FriendsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $friends = array();

        for ($i = 0; $i <= 100000; $i++) {
            $write = true;

            $friends[$i][0] = mt_rand(1, 1000);
            do {
                $friends[$i][1] = mt_rand(1, 1000);

                for ($j = 0; $j < $i; $j++) {
                    if (($friends[$i][0] == $friends[$j][0] && $friends[$i][1] == $friends[$j][1]) ||
                        ($friends[$i][0] == $friends[$j][1] && $friends[$i][1] == $friends[$j][0]))
                    {
                        $write = false;
                        break;
                    }
                }

            } while ($friends[$i][0] == $friends[$i][1]);


            if ($write) {
                DB::table('friends')->insert([
                    'user_id_1' => $friends[$i][0],
                    'user_id_2' => $friends[$i][1],
                    'confirmed' => mt_rand(0, 1)
                ]);
            }
        }
    }
}
