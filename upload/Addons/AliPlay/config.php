<?php
return array(
	'group'=>array(
		'type'=>'group',
		'options'=>array(
			'basicsettings'=>array(
				'title'=>'基本设置',
				'options'=>array(
					'pay_type'=>array(//配置在表单中的键名 ,这个会是config[random]
					'title'=>'使用类型:',	 //表单的文字
					'type'=>'select',		 //表单的类型：text、textarea、checkbox、radio、select等
					'options'=>array(		 //select 和radion、checkbox的子选项
						'1'=>'担保交易',		 //值=>文字
						'2'=>'即时交易',
						//'3'=>'网银交易',
					),
					'value'=>1,			 //表单的默认值
					),
					'codelogin'=>array(
						'title'=>'是否启用支付宝:',
						'type'=>'radio',
						'options'=>array(
							'1'=>'开启',
							'0'=>'关闭'
						),
						'value'=>1,
						'tip'=>'必须在这里开启以后才能使用此功能'
					)
				)
			),
			'developer'=>array(
				'tip'=>'这个页面配置的信息都可以在支付宝上获取到，随便填写不起任何作用',
				'title'=>'账户设置',
				'options'=>array(
					'PARTNER'=>array(
						'title'=>'合作身份者id:',
						'type'=>'text',		 
						'value'=>$partner,
						'tip'=>'合作身份者id，以2088开头的16位纯数字'
					),
					'KEY'=>array(
						'title'=>'安全检验码:',
						'type'=>'text',
						'value'=>$key,	
						'tip'=>'安全检验码，以数字和字母组成的32位字符'
					),
					'SELLER_EMAIL'=>array(
						'title'=>'收款帐户:',
						'type'=>'text',
						'value'=>$seller_email,	
						'tip'=>'卖家支付宝帐户'
					),
				)
			)
		)
	)
);	