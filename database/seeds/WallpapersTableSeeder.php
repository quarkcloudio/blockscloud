<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Services\Helper;
class WallpapersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wallpapers')->insert([
             [
                'title' => 'AndromedaGalaxy',
                'cover_path' => './images/wallpapers/1.jpg',
             ],
             [
                'title' => 'Beach',
                'cover_path' => './images/wallpapers/2.jpg',
             ],
             [
                'title' => 'DucksonaMistyPond',
                'cover_path' => './images/wallpapers/3.jpg',
             ],
             [
                'title' => 'EagleWaterfall',
                'cover_path' => './images/wallpapers/4.jpg',
             ],
             [
                'title' => 'Flamingos',
                'cover_path' => './images/wallpapers/5.jpg',
             ],
             [
                'title' => 'ForestinMist',
                'cover_path' => './images/wallpapers/6.jpg',
             ],
             [
                'title' => 'Isles',
                'cover_path' => './images/wallpapers/7.jpg',
             ],
             [
                'title' => 'Lake',
                'cover_path' => './images/wallpapers/8.jpg',
             ],
             [
                'title' => 'MtFuji',
                'cover_path' => './images/wallpapers/9.jpg',
             ],
             [
                'title' => 'PinForest',
                'cover_path' => './images/wallpapers/10.jpg',
             ],
             [
                'title' => 'Lion',
                'cover_path' => './images/wallpapers/11.jpg',
             ],
             [
                'title' => 'Moon',
                'cover_path' => './images/wallpapers/12.jpg',
             ],
        ]);
    }
}
