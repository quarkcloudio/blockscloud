<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
class KeyValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersInfo = DB::table('users')->where('id', 1)->first();
        $keyValue['wallpaper'] = 1;
        DB::table('key_values')->insert([
             [
                'collection' => 'users.wallpaper',
                'uuid' => $usersInfo->uuid,
                'data' => json_encode($keyValue),
             ]
        ]);
    }
}
