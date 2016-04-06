<?php

return array(
    'type'=>array(
        'title'=>'开启同步登录：',
        'type'=>'checkbox',
        'options'=>array(
            'Qq'=>'Qq',
            'Sina'=>'Sina',
        ),
    ),
    'meta'=>array(//配置在表单中的键名 ,这个会是config[title]
        'title'=>'接口验证代码：',//表单的文字
        'type'=>'textarea',		 //表单的类型：text、textarea、checkbox、radio、select等
        'value'=>'',			 //表单的默认值
        'tip'=>'需要在Meta标签中写入验证信息时，拷贝代码到这里。'
    ),
    'bind'=>array(//配置在表单中的键名 ,这个会是config[title]
        'title'=>'是否开启帐号绑定：',//表单的文字
        'type'=>'radio',		 //表单的类型：text、textarea、checkbox、radio、select等
        'options'=>array(
            '1'=>'是',
            '0'=>'否',
        ),
        'value'=>'0',
        'tip'=>'不开启则跳过与本地帐号绑定过程，建议审核时关闭绑定。'
    ),

    'group'=>array(
        'type'=>'group',
        'options'=>array(
            'Qq'=>array(
                'title'=>'QQ配置',
                'options'=>array(
                    'QqKEY'=>array(
                        'title'=>'QQ互联KEY：',
                        'type'=>'text',
                        'value'=>'',
                        'tip'=>'申请地址：http://connect.qq.com',
                    ),
                    'QqSecret'=>array(
                        'title'=>'QQ互联密匙：',
                        'type'=>'text',
                        'value'=>'',
                        'tip'=>'申请地址：http://connect.qq.com',
                    )
                ),
             ),
            'Sina'=>array(
                'title'=>'新浪配置',
                'options'=>array(

                    'SinaKEY'=>array(
                        'title'=>'新浪KEY：',
                        'type'=>'text',
                        'value'=>'',
                        'tip'=>'申请地址：http://open.weibo.com/',
                    ),
                    'SinaSecret'=>array(
                        'title'=>'新浪密匙：',
                        'type'=>'text',
                        'value'=>'',
                        'tip'=>'申请地址：http://open.weibo.com/',
                    )

                ),

            )
        )
    )



);
