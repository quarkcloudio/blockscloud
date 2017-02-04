<?php

use Illuminate\Database\Seeder;

class SystemFileInfosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_file_infos')->insert([
             [
                'title' => '文件夹',
                'file_type' => 'dir',
                'file_icon' => './images/apps/GenericFolderIcon.png',
                'app_id' =>6,
                'context'=>'finder',
             ],
             [
                'title' => '文本文件',
                'file_type' => 'txt',
                'file_icon' => './images/apps/txt.png',
                'app_id' =>7,
                'context'=>'file',
             ],
             [
                'title' => 'png文件',
                'file_type' => 'png',
                'file_icon' => './images/apps/jpeg.png',
                'app_id' =>8,
                'context'=>'file',
             ],
             [
                'title' => 'jpg文件',
                'file_type' => 'jpg',
                'file_icon' => './images/apps/jpeg.png',
                'app_id' =>8,
                'context'=>'file',
             ],
             [
                'title' => '未知文件类型',
                'file_type' => 'unknown',
                'file_icon' => './images/apps/unknown.png',
                'app_id' =>9,
                'context'=>'file',
             ],
             [
                'title' => 'mp3文件',
                'file_type' => 'mp3',
                'file_icon' => './images/apps/mp3.png',
                'app_id' =>10,
                'context'=>'file',
             ],
             [
                'title' => 'doc文件',
                'file_type' => 'doc',
                'file_icon' => './images/apps/doc.png',
                'app_id' =>11,
                'context'=>'file',
             ],
             [
                'title' => 'docx文件',
                'file_type' => 'docx',
                'file_icon' => './images/apps/doc.png',
                'app_id' =>11,
                'context'=>'file',
             ],
             [
                'title' => 'xls文件',
                'file_type' => 'xls',
                'file_icon' => './images/apps/xls.png',
                'app_id' =>11,
                'context'=>'file',
             ],
             [
                'title' => 'ppt文件',
                'file_type' => 'ppt',
                'file_icon' => './images/apps/ppt.png',
                'app_id' =>11,
                'context'=>'file',
             ],
             [
                'title' => 'mp4文件',
                'file_type' => 'mp4',
                'file_icon' => './images/apps/video.png',
                'app_id' =>12,
                'context'=>'file',
             ]
        ]);
    }
}
