<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 100000; $i++) {

            $id1 = mt_rand(1, 1000);
            do {
                $id2 = mt_rand(1, 1000);
            } while($id1 == $id2);

            $answered = mt_rand(0, 1);
            $anonimous = mt_rand(0, 1);

            if ($answered) {
                DB::table('questions')->insert([
                    'question' => 'test question' . $i,
                    'question_man' => $id1,
                    'question_time' => '01-01-2014',
                    'answer' => 'test answer' . $i,
                    'answer_man' => $id2,
                    'answer_time' => '01-01-2015',
                    'answered' => $answered,
                    'anonimous' => $anonimous,
                ]);
            } else {
                DB::table('questions')->insert([
                    'question' => 'test question' . $i,
                    'question_man' => $id1,
                    'question_time' => '01-01-2014',
                    'answer_man' => $id2,
                    'anonimous' => $anonimous,
                ]);
            }
        }
    }
}
