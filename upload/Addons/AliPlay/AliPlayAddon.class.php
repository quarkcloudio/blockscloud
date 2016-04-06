<?php

namespace Addons\AliPlay;
use Common\Controller\Addon;

/**
 * 支付宝插件
 * @author tangtanglove
 * QQ:869716224
 */

    class AliPlayAddon extends Addon{

        public $info = array(
            'name'=>'AliPlay',
            'title'=>'支付宝',
            'description'=>'支付宝插件,后台配置支持变量。如：价格：$GOODS["price"].但是配置的变量要和数据库商品信息一致。',
            'status'=>1,
            'author'=>'tangtanglove',
            'version'=>'3.1'
        );
        public function install(){
			//添加钩子
			$Hooks = M("Hooks");
			$AliPlay = array(array(
				'name' => 'indexAliPlay',
				'description' => '支付宝钩子',
				'type' => 1,
				'update_time' => NOW_TIME,
				'addons' => 'indexAliPlay'
			));
			$Hooks->addAll($AliPlay,array(),true);
			if ( $Hooks->getDbError() ) {
				session('addons_install_error',$Hooks->getError());
				return false;
			}
            return true;
        }

        public function uninstall(){
			$Hooks = M("Hooks");
			$map['name']  = array('in','indexAliPlay');
			$res = $Hooks->where($map)->delete();
			if($res == false){
				session('addons_install_error',$Hooks->getError());
				return false;
			}
            return true;
        }
		
        //实现的indexAliPlay钩子方法
        public function indexAliPlay($param){
			$config = $this->getConfig();
			//检查插件是否开启
			if($config['codelogin']){
				$post=get_addon_config('AliPlay');
				if($config['PARTNER'])
				{
					//判断用户选择的接口类型，决定配置文件的写入路径
					$pay_type='';
					switch($config['pay_type']){
						case 1:
							$pay_type='AliPlayEscow';
						break;
						case 2:
							$pay_type='AliPlayDirect';
						break;
						case 3:
							$pay_type='wangguan';
						break;
					
					}
						//读取文件中的内容
						$str=file_get_contents("./Addons/AliPlay/Play/".$pay_type."/lib/aliplay.php");
						$zz=array();
						$rep=array();
						foreach($post as $key=>$value ){
							$zz[]="/define\(\"{$key}\",\s*.*?\);/i";
							$rep[]="define(\"{$key}\", \"{$value}\");";		
						}
						//改写文件中的内容
						$str=preg_replace($zz, $rep, $str);		
						file_put_contents("./Addons/AliPlay/Play/".$pay_type."/lib/aliplay.php", $str);


						$data['out_trade_no']		=		$this->createOrderNo();//订单号
						$data['subject']			=		"账户充值";//订单名称;
						$data['price']				=		"";//付款金额;
						$data['logistics_fee']		=		 0;//物流费用;
						$data['logistics_type']		=		"POST";//物流类型;
						$data['logistics_payment']	=		"SELLER_PAY";//物流支付方式;
						$data['body']				=		"账户充值";//订单描述;
						$data['show_url']			=		"";//商品展示地址;
						$data['receive_name']		=		"虚拟货币";//收货人姓名;
						$data['receive_address']	=		"虚拟货币";//收货人地址;
						$data['receive_zip']		=		"064400";//收货人邮编;
						$data['receive_mobile']		=		"15076569631";//收货人手机号码;
						$data['receive_phone']		=		"15076569631";//收货人电话号码;


						$this->assign('data', $data);
						$this->assign('pay_type', $pay_type);
						$this->assign('config', $config);
						$this->display('AliPlay');
						
				}
			}
				
        }

        //生成订单号
	    public function createOrderNo() {
	        $year_code = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
	        return $year_code[intval(date('Y')) - 2010] .
	                strtoupper(dechex(date('m'))) . date('d') .
	                substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('d', rand(0, 99));
	    }
	

    }