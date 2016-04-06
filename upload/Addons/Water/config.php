<?php

return array(
    'switch' => array( //配置在表单中的键名 ,这个会是config[title]
        'title' => '是否开启添加水印：', //表单的文字
        'type' => 'radio', //表单的类型：text、textarea、checkbox、radio、select等
        'options' => array(
            '1' => '是',
            '0' => '否',
        ),
        'value' => '1',
        'tip' => '默认关闭水印'
    ),
    'water' => array(
        'title' => '水印图片',
        'type' => 'water',
        'value' => '',
    ),
    'position' => array(
        'title' => '水印位置',
        'type'=>'select',		 //表单的类型：text、textarea、checkbox、radio、select等
        'options'=>array(		 //select 和radion、checkbox的子选项
            '1'=>'左上',		 //值=>文字
            '2'=>'中上',
            '3'=>'右上',
            '4'=>'左中',
            '5'=>'中间',
            '6'=>'右中',
            '7'=>'左下',
            '8'=>'中下',
            '9'=>'右下',

        ),
        'value'=>'9',
        'tip' => '配置水印的位置'
    )

);
