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
        return User::create([
            'uuid' => $uuid,
            'name' => 'administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ]);
    }
}
