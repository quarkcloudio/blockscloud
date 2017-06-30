<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Services\Helper;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uuid = Helper::createUuid();

        // 初始化桌面文件
        Helper::makeDir(Helper::appToSystemChar(storage_path('app/public/user/administrator')));
        Helper::copyFileToDir(Helper::appToSystemChar(storage_path('app/public/desktop/home/')),Helper::appToSystemChar(storage_path('app/public/user/administrator')));
        Helper::copyFileToDir(Helper::appToSystemChar(storage_path('app/public/desktop/recycle/')),Helper::appToSystemChar(storage_path('app/public/user/administrator')));

        return User::create([
            'uuid' => $uuid,
            'name' => 'administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'status' => 1,
        ]);
    }
}
