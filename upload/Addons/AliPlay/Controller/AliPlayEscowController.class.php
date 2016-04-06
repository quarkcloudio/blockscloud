<?php

namespace Addons\AliPlay\Controller;
use Home\Controller\AddonsController;

class AliPlayEscowController extends AddonsController{

	public function alipayPost()
	{
		$filepath = './Addons/AliPlay/Play/AliPlayEscow/';
		require_once($filepath."alipay.config.php");
		require_once($filepath."lib/alipay_notify.class.php");
		require_once($filepath."lib/aliplay.php");
		require_once($filepath."lib/alipay_submit.class.php");
		/**************************请求参数**************************/

		        //支付类型
		        $payment_type = "1";
		        //必填，不能修改
		        //服务器异步通知页面路径
				$get_notify_url=addons_url("AliPlay://AliPlayEscow/notifyUrl");
				$get_notify_url=preg_replace('/.html/i','',$get_notify_url);
				$get_notify_url="http://".$_SERVER['HTTP_HOST'].$get_notify_url;
				$get_notify_url=str_replace('?s=','',$get_notify_url);
		        $notify_url = $get_notify_url;
		        //需http://格式的完整路径，不能加?id=123这类自定义参数

		        //页面跳转同步通知页面路径
				$get_return_url=addons_url("AliPlay://AliPlayEscow/returnUrl");
				$get_return_url=preg_replace('/.html/i','',$get_return_url);
				$get_return_url="http://".$_SERVER['HTTP_HOST'].$get_return_url;
				$get_return_url=str_replace('?s=','',$get_return_url);
		        $return_url = $get_return_url;
		        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

		        //商户订单号
		        $out_trade_no = $_POST['out_trade_no'];
		        //商户网站订单系统中唯一订单号，必填

		        //订单名称
		        $subject = $_POST['subject'];
		        //必填

		        //付款金额
		        $price = $_POST['price'];
		        //必填

		        //商品数量
		        $quantity = "1";
		        //必填，建议默认为1，不改变值，把一次交易看成是一次下订单而非购买一件商品
		        //物流费用
		        $logistics_fee = "0.00";
		        //必填，即运费
		        //物流类型
		        $logistics_type = "EXPRESS";
		        //必填，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
		        //物流支付方式
		        $logistics_payment = "SELLER_PAY";
		        //必填，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）
		        //订单描述

		        $body = $_POST['body'];
		        //商品展示地址
		        $show_url = $_POST['show_url'];
		        //需以http://开头的完整路径，如：http://www.商户网站.com/myorder.html

		        //收货人姓名
		        $receive_name = $_POST['receive_name'];
		        //如：张三

		        //收货人地址
		        $receive_address = $_POST['receive_address'];
		        //如：XX省XXX市XXX区XXX路XXX小区XXX栋XXX单元XXX号

		        //收货人邮编
		        $receive_zip = $_POST['receive_zip'];
		        //如：123456

		        //收货人电话号码
		        $receive_phone = $_POST['receive_phone'];
		        //如：0571-88158090

		        //收货人手机号码
		        $receive_mobile = $_POST['receive_mobile'];
		        //如：13312341234


		        //这里根据自己的逻辑处理
				$user = session('user_auth');
				$recharge_data['uid']			=	$user['uid'];
				$recharge_data['order']			=	$out_trade_no;
				$recharge_data['money']			=	$price;
				$recharge_data['recharge_way']	=	"支付宝担保交易";
				$recharge_data['createtime']	=	strtotime("now");
				$ifHas=M('Recharge')->where(array('order'=>$out_trade_no))->find();
				if ($ifHas) {
					$this->error("订单号重复！");
				}else{
					$result=M('Recharge')->add($recharge_data);
				}

		/************************************************************/
		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "create_partner_trade_by_buyer",
				"partner" => trim($alipay_config['partner']),
				"seller_email" => trim($alipay_config['seller_email']),
				"payment_type"	=> $payment_type,
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"price"	=> $price,
				"quantity"	=> $quantity,
				"logistics_fee"	=> $logistics_fee,
				"logistics_type"	=> $logistics_type,
				"logistics_payment"	=> $logistics_payment,
				"body"	=> $body,
				"show_url"	=> $show_url,
				"receive_name"	=> $receive_name,
				"receive_address"	=> $receive_address,
				"receive_zip"	=> $receive_zip,
				"receive_phone"	=> $receive_phone,
				"receive_mobile"	=> $receive_mobile,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);

		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		header("Content-type:text/html;charset=utf-8");
		if ($result) {
			echo $html_text;
		}else{
			$this->error("订单创建失败！");
		}
	}



	/**
	 * [returnUrl 支付后返回]
	 * @return [type] [description]
	 */
	public function returnUrl()
	{
		$filepath = './Addons/AliPlay/Play/AliPlayEscow/';
		require_once($filepath."alipay.config.php");
		require_once($filepath."lib/alipay_notify.class.php");
		require_once($filepath."lib/aliplay.php");
		require_once($filepath."lib/alipay_submit.class.php");
		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyReturn();
		if($verify_result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代码
			
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
		    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

			//商户订单号

			$out_trade_no = $_GET['out_trade_no'];

			//支付宝交易号

			$trade_no = $_GET['trade_no'];

			//交易状态
			$trade_status = $_GET['trade_status'];


		    if($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {

		    	$where['order']=$out_trade_no;
		    	$get_recharge_info=M('Recharge')->where($where)->find();
		    	if ($get_recharge_info['status'] == 'WAIT_BUYER_PAY') {
					$data['trade_no'] = $_GET['trade_no'];
					$data['status']='WAIT_SELLER_SEND_GOODS';
					$result=M('Recharge')->where($where)->save($data);
		    	}elseif ($get_recharge_info['status'] == 'WAIT_SELLER_SEND_GOODS') {
		    		$result = 1;
		    	}
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
		    }
		    else {
		      echo "trade_status=".$_GET['trade_status'];
		    }
		    if ($result) {
		    	$get_notify_url=addons_url("AliPlay://AliPlayEscow/sendConfirm/trade_no/".$trade_no);
		    	$this->success('支付成功！',$get_notify_url);
		    }
				
			echo "验证成功<br />";
			echo "trade_no=".$trade_no;

			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else {
		    //验证失败
		    //如要调试，请看alipay_notify.php页面的verifyReturn函数
		    echo "验证失败";
		}
	}



	/**
	 * [notifyUrl 异步通知]
	 * @return [type] [description]
	 */
	public function notifyUrl()
	{
		$filepath = './Addons/AliPlay/Play/AliPlayEscow/';
		require_once($filepath."alipay.config.php");
		require_once($filepath."lib/alipay_notify.class.php");
		require_once($filepath."lib/aliplay.php");
		require_once($filepath."lib/alipay_submit.class.php");
			//计算得出通知验证结果
			$alipayNotify = new AlipayNotify($alipay_config);
			$verify_result = $alipayNotify->verifyNotify();

			if($verify_result) {//验证成功
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//请在这里加上商户的业务逻辑程序代

				
				//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
				
			    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
				
				//商户订单号

				$out_trade_no = $_POST['out_trade_no'];

				//支付宝交易号

				$trade_no = $_POST['trade_no'];

				//交易状态
				$trade_status = $_POST['trade_status'];
		    	$where['order']=$out_trade_no;

				if($_POST['trade_status'] == 'WAIT_BUYER_PAY') {
				//该判断表示买家已在支付宝交易管理中产生了交易记录，但没有付款
				
					//判断该笔订单是否在商户网站中已经做过处理
						//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
						//如果有做过处理，不执行商户的业务程序
				
			        echo "success";		//请不要修改或删除

			        //调试用，写文本函数记录程序运行情况是否正常
			        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			    }
				else if($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
				//该判断表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货
				
					//判断该笔订单是否在商户网站中已经做过处理
						//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
						//如果有做过处理，不执行商户的业务程序
					
					$data['status']='WAIT_SELLER_SEND_GOODS';
					$result=M('Recharge')->where($where)->save($data);		
			        echo "success";		//请不要修改或删除

			        //调试用，写文本函数记录程序运行情况是否正常
			        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			    }
				else if($_POST['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS') {
				//该判断表示卖家已经发了货，但买家还没有做确认收货的操作
				
					//判断该笔订单是否在商户网站中已经做过处理
						//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
						//如果有做过处理，不执行商户的业务程序
					$data['status']='WAIT_BUYER_CONFIRM_GOODS';
					$result=M('Recharge')->where($where)->save($data);	
			        echo "success";		//请不要修改或删除

			        //调试用，写文本函数记录程序运行情况是否正常
			        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			    }
				else if($_POST['trade_status'] == 'TRADE_FINISHED') {
				//该判断表示买家已经确认收货，这笔交易完成
				
					//判断该笔订单是否在商户网站中已经做过处理
						//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
						//如果有做过处理，不执行商户的业务程序
					$data['status']='TRADE_FINISHED';
					$result=M('Recharge')->where($where)->save($data);
					$get_recharge=M('Recharge')->where($where)->find();
					if ($result) {
						$getInfo=$Member->where(array('uid'=>$get_recharge['uid']))->find();
						$nowmoney=$getInfo['money']+$get_recharge['money'];
						$result1=$Member->where(array('uid'=>$get_recharge['uid']))->save(array('money'=>$nowmoney));
						if ($result1) {	
							echo "success";		
							//$this->success("支付成功","Recharge/alipaysucc/recharge_money/".$get_recharge['money']);
						}else{
							echo "支付故障，请联系客服！";
						}
					}
			        //echo "success";		//请不要修改或删除

			        //调试用，写文本函数记录程序运行情况是否正常
			        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			    }
			    else {
					//其他状态判断
			        echo "success";

			        //调试用，写文本函数记录程序运行情况是否正常
			        //logResult ("这里写入想要调试的代码变量值，或其他运行的结果记录");
			    }

				//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
				
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			}
			else {
			    //验证失败
			    echo "fail";

			    //调试用，写文本函数记录程序运行情况是否正常
			    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			}


	}



	/**
	 * [sendConfirm 自动确认发货]
	 * @return [type] [description]
	 */
	public function sendConfirm()
	{
		$filepath = './Addons/AliPlay/Play/AliPlayEscow/';
		require_once($filepath."alipay.config.php");
		require_once($filepath."lib/alipay_notify.class.php");
		require_once($filepath."lib/aliplay.php");
		require_once($filepath."lib/alipay_submit.class.php");

		/**************************请求参数**************************/

		        //支付宝交易号
		        $trade_no=I("get.trade_no");
		        //$trade_no = $_POST['WIDtrade_no'];
		        //必填

		        //物流公司名称
		        $logistics_name = "爱小圈";
		        //$logistics_name = $_POST['WIDlogistics_name'];
		        //必填

		        //物流发货单号

		        $invoice_no = I("get.trade_no");
		        //物流运输类型
		        //$transport_type = $_POST['WIDtransport_type'];
		        //三个值可选：POST（平邮）、EXPRESS（快递）、EMS（EMS）


		/************************************************************/

		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "send_goods_confirm_by_platform",
				"partner" => trim($alipay_config['partner']),
				"trade_no"	=> $trade_no,
				"logistics_name"	=> $logistics_name,
				"invoice_no"	=> $invoice_no,
				"transport_type"	=> $transport_type,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);

		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestHttp($parameter);
		//解析XML
		//注意：该功能PHP5环境及以上支持，需开通curl、SSL等PHP配置环境。建议本地调试时使用PHP开发软件
		$doc = new \DOMDocument();
		$doc->loadXML($html_text);

		//请在这里加上商户的业务逻辑程序代码

		//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

		//获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

		//解析XML
		if( ! empty($doc->getElementsByTagName( "alipay" )->item(0)->nodeValue) ) {
			$alipay = $doc->getElementsByTagName( "alipay" )->item(0)->nodeValue;
			echo $alipay;
		}


		$where['trade_no']=$trade_no;
		$data['status']='WAIT_BUYER_CONFIRM_GOODS';
		$result=M('Recharge')->where($where)->save($data);

		$this->success('请您登录支付宝，确认收货，系统将自动完成充值！',U('https://www.alipay.com'));

	}




}
