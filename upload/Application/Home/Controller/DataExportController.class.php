<?php

namespace Admin\Controller;

class DataExportController extends CommonController {

/**
 * [dateFormat 日期格式化]
 * @param  [日期参数]
 * @return [type]
 */
    public function dateFormat($date)
    {
    	 $arr=explode(" ",$date);
    	 return $arr[0]." 0:00:00";
    }


    //导出数据
    public function exportWithdrawalsData()
    {
  		//excel参数
  		$fileName="直销系统提现信息表_";
  		$excelTitle="直销系统提现信息表_";


  		$header=array(
					array("value"=>"序号","cell"=>"A1"),
					array("value"=>"银行账号","cell"=>"B1"),
					array("value"=>"提现账号","cell"=>"C1"),
					array("value"=>"提现金额","cell"=>"D1"),
					array("value"=>"扣税金额","cell"=>"E1"),
					array("value"=>"打款金额","cell"=>"F1"),
					array("value"=>"真实姓名","cell"=>"G1"),
					array("value"=>"银行卡号","cell"=>"H1"),
					array("value"=>"联系电话","cell"=>"I1"),
					array("value"=>"申请时间","cell"=>"J1"),
  					);

  		//合并处理数组
  		$cellList=$this->getWithdrawalsList($header);
  		//导出excel文件
  		$this->exportExcelBussProgress($fileName,$cellList);


    }
    /**
     * 获得提现申请成功但是未打款的所有信息
     * 
     */
    public function getWithdrawalsList($header)
    {

		$list = M('withdrawals')
		->alias('a')
		->join('user b ON b.id= a.user_id')
		->where(array('a.status'=>1))
		->field('b.*,a.withdrawals_id,a.withdrawals_money,a.time')->select();

    	$arr=array();
		$currentRow=2;
    	foreach ($list as $key => $value) {
			for($currentColumn='A';$currentColumn!='K';$currentColumn++){
				//数据坐标
				$address=$currentColumn.$currentRow;
				switch ($currentColumn) {
					case 'A':$res=$value['withdrawals_id'];break;
					case 'B':$res=(string)" ".$value['user_bankcard'];break;
					case 'C':$res=$value['username'];break;
					case 'D':$res=(double)$value['withdrawals_money'];break;
					case 'E':$res=(double)($value['withdrawals_money']*0.05);break;
					case 'F':$res=(double)($value['withdrawals_money']*0.95);break;
					case 'G':$res=$value['realname'];break;
					case 'H':$res=(string)" ".$value['banknumber'];break;
					case 'I':$res=(string)" ".$value['mobile'];break;
					case 'J':$res=(string)" ".time_format($value['time']);break;
					default:
						# code...
						break;
				}

				//读取到的数据，保存到数组$arr中
	    		$arr1=array(array("value"=>$res,"cell"=>$address));
				$arr=array_merge_recursive($arr,$arr1);
				unset($arr1);
			}

    		$currentRow++;
    	}

    	return array_merge_recursive($header,$arr);



    }

    /**
     * [exportExcelBussProgress 导出excel文件]
     * @param  [type] $fileName [文件名称]
     * @param  [type] $cellList [单元格值]
     * @return [type]           [description]
     */
	public function exportExcelBussProgress($fileName,$cellList)
	{
		import("Org.Util.PHPExcel");
		import("Org.Util.PHPExcel.Writer.Excel5");
		import("Org.Util.PHPExcel.IOFactory.php");
    	$cacheMethod = \PHPExcel_CachedObjectStorageFactory::cache_in_memory;  
    	\PHPExcel_Settings::setCacheStorageMethod($cacheMethod);  

    	$PHPExcel=new \PHPExcel();
    	$PHPExcel_IOFactory=new \PHPExcel_IOFactory();
	    $objActSheet = $PHPExcel->getActiveSheet();

	    foreach ($cellList as $key => $value) {

	    	//存在merge，合并单元格
	    	if (!empty($value['merge'])) {
        		$objActSheet->mergeCells($value['merge']);
	    	}

			//设置居中 
		    $objActSheet->getStyle($value['cell'])
	    	->getAlignment()
	    	->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
	    	->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER); 
	    	//字体样式对象
	    	//$fontStyle=$objActSheet->getStyle($value['cell'])->getFont();
		 	//设置字体
			//$fontStyle->setName('宋体');
			//设置字体大小
	   //  	if (!empty($value['font-size'])) {
				// $fontStyle->setSize($value['font-size']);
		 	//     }else{
		 	//     	$fontStyle->setSize('10');
		 	//     }
		 	//设置字体颜色
		 	// if (!empty($value['color'])) {
		 	// 	$objActSheet->getStyle($value['cell'])->getFont()->getColor()->setARGB($value['color']);
		 	// }
	    	//设置单元格值
        	$objActSheet->setCellValue($value['cell'],$value['value']);
        	//最后一个单元格地址
			$endaddress=$value['cell'];
	    }

    	//设置边框  
		// $styleThinBlackBorderOutline = array(
		//     'borders' => array (
		//        'allborders' => array (
		//           'style' => \PHPExcel_Style_Border::BORDER_THIN,  //设置border样式
		//           //'style' => PHPExcel_Style_Border::BORDER_THICK, 另一种样式
		//           'color' => array ('argb' => 'FF000000'),     //设置border颜色
		//       ),
		//    ),
		// );
// 		$objActSheet->getStyle("A3:$endaddress")->applyFromArray($styleThinBlackBorderOutline);



		$ExcelName = iconv("utf-8", "gb2312", "$fileName").date('Y_m_d_his');;
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name='.$ExcelName.'.xls');
        header("Content-Disposition:attachment;filename=$ExcelName.xls");//attachment新窗口打印inline本窗口打印
	  	$objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
	    $objWriter->save('php://output'); //文件通过浏览器下载
	    exit;
	}


}
