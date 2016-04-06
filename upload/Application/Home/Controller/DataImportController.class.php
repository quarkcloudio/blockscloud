<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;

/**
 * 后台首页控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class DataImportController extends HomeController {

    /**
     * 后台首页
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index(){
		$this->display();
    }


    //把数据导入到数据库by tangtanglove
    public function importData()
    {
    	//导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
		import("Org.Util.PHPExcel");
		//要导入的xls文件，位于根目录下的Public文件夹
		$filename="./news.xlsx";
		//创建PHPExcel对象，注意，不能少了\
		$PHPExcel=new \PHPExcel();
		//如果excel文件后缀名为.xls，导入这个类
		//import("Org.Util.PHPExcel.Reader.Excel5");
		//如果excel文件后缀名为.xlsx，导入这下类
		import("Org.Util.PHPExcel.Reader.Excel2007");
		$PHPReader=new \PHPExcel_Reader_Excel2007();

		//$PHPReader=new \PHPExcel_Reader_Excel5();
		//载入文件
		$PHPExcel=$PHPReader->load($filename);
		//获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
		$currentSheet=$PHPExcel->getSheet(0);
		//获取总列数
		$allColumn=$currentSheet->getHighestColumn();

		//获取总行数
		$allRow=$currentSheet->getHighestRow();

		$Document	=	M("Document");

		//循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
		for($currentRow=1;$currentRow<=$allRow;$currentRow++){
			//从哪列开始，A表示第一列
			for($currentColumn='A';$currentColumn!='BA';$currentColumn++){
				//数据坐标
				$address=$currentColumn.$currentRow;
				//读取到的数据，保存到数组$arr中
				//$arr[$currentRow][$currentColumn]=$currentSheet->getCell($address)->getValue();
		        if($currentColumn=='L'){//指定H列为时间所在列  
		           $value[$currentColumn] = gmdate("Y-m-d H:i:s", \PHPExcel_Shared_Date::ExcelToPHP($currentSheet->getCell($address)->getValue()));   
		        }else{  
		           $value[$currentColumn] = $currentSheet->getCell($address)->getValue();
		        }  
				//$value[$currentColumn]=$currentSheet->getCell($address)->getValue();
			}

				$catid = trim ( $value ['B'] );
				$title = trim ( $value ['C'] );
				$content = trim ( $value ['D'] );
				$description = trim ( $value ['E'] );
				//echo $value ['L'];
				$create_time = strtotime ($value ['L']);
				switch ($catid) {
					case '4':
						$data['category_id'] = 51;
						break;
					case '5':
						$data['category_id'] = 1;
						break;
					case '6':
						$data['category_id'] = 39;
						break;
					case '7':
						$data['category_id'] = 40;
						break;
					case '8':
						$data['category_id'] = 41;
						if ($description) {
							$data['description'] = $description;
							$content = $description;
						}
						break;
					case '2':
						$data['category_id'] = 42;
						break;
					case '3':
						$data['category_id'] = 51;
						break;
					default:
						# code...
						break;
				}
				$data['title'] = $title;
				$data['create_time'] = $create_time;
				$data['status'] = 1;
				$data['uid'] = 1;
				$data['model_id'] = 2;
				$id = $Document->add($data);
				if (!empty($id)) {
					M('DocumentArticle')->add(array('id'=>$id,'content'=>$content));
				}
		}

    }


}
