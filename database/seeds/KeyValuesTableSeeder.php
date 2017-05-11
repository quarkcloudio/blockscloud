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
        $wallpaper['wallpaper'] = 1;

        $config['web_site_title'] = '积木云-您的私人云空间';
        $config['web_site_keyword'] = '积木云，积木云官网网站, 积木云官网';
        $config['web_site_description'] = '积木云是为用户精心打造的一项智能云服务，您的私人网上家园。';
        $config['web_site_close'] = 1;

        DB::table('key_values')->insert([
             [
                'collection' => 'users.wallpaper',
                'uuid' => $usersInfo->uuid,
                'data' => json_encode($wallpaper),
             ],
             [
                'collection' => 'website.config',
                'uuid' => $usersInfo->uuid,
                'data' => json_encode($config),
             ],
        ]);
    }
}
