<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Services\Helper;
class DocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('docks')->insert([
             [
                'uid' => 1,
                'app_id' => 3,
                'sort' => 0
             ],
             [
                'uid' => 1,
                'app_id' => 4,
                'sort' => 1
             ],
             [
                'uid' => 1,
                'app_id' => 6,
                'sort' => 2
             ],
             [
                'uid' => 1,
                'app_id' => 13,
                'sort' => 3
             ],
             [
                'uid' => 1,
                'app_id' => 14,
                'sort' => 4
             ],
        ]);
    }
}
