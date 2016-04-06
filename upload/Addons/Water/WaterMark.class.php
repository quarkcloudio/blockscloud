<?php
	/**
	 * It's mark water image for our's image 
	 * Create Time:06/30/2009
	 * Author:Daker.W
	 * QQ:451021477
	 */
	class WaterMark
	{
		private $baseImgPath		= '';				//base image path
		private $waterImgPath		= '';				//water image path
		private $baseImg, $waterImg;
		private $base_w, $base_h;
		private $water_w, $water_h;
		/**
		 * $waterPos
		 * 0 random, 1 top left, 2 top center, 3 top right
		 * 			 4 center left, 5 center center, 6 center right
		 * 			 7 bottom left, 8 bottom center, 9 bottom right 
		 */
		private $waterPos			= 9;
		private $waterInfo			= '';
		private $baseInfo			= '';
		private $textFont; 								//1,2,3,4,5 default5
		private $textColor			= '#FF0000';
		private $waterText			= ''; 				//not support chinese
		private $ttfPath			= '';
		private $isWaterImg;							// water type: image(true) or text(false)
		private $debug				= true;
		private $errorMsgs			= '';
		
		
		/**
		 * @param $baseImgPath 
		 * @param $waterPos
		 */
		function __construct($baseImgPath, $waterPos=9)
		{
			$this->baseImgPath			= $baseImgPath;
			$this->waterPos				= $waterPos;
			$this->baseInfo				= getimagesize($this->baseImgPath);
			if (file_exists($this->baseImgPath)){
				switch ($this->baseInfo[2]){
					case 1: $this->baseImg			= imagecreatefromgif($this->baseImgPath);
						break;
					case 2:	$this->baseImg			= imagecreatefromjpeg($this->baseImgPath);
						break;
					case 3: $this->baseImg			= imagecreatefrompng($this->baseImgPath);
						break;
					default:$errorMsg			= 'base image type is wrong';
						$this->debug($errorMsg);
				}//END SWITCH
			}else {
				$errorMsg			= 'base image is not exists';
				$this->debug($errorMsg);
			}//END IF
			$this->base_w				= $this->baseInfo[0];
			$this->base_h				= $this->baseInfo[1];
		}
		
		/**
		 * @param $waterImgPath 
		 */
		function setWaterImage($waterImgPath)
		{
			$this->waterImgPath			= $waterImgPath;
			$this->waterInfo			= getimagesize($this->waterImgPath);
			if (file_exists($this->waterImgPath)){
				switch ($this->waterInfo[2]){
					case 1: $this->waterImg			= imagecreatefromgif($this->waterImgPath);
						break;
					case 2:	$this->waterImg			= imagecreatefromjpeg($this->waterImgPath);
						break;
					case 3: $this->waterImg			= imagecreatefrompng($this->waterImgPath);
						break;
					default:$errorMsg			= 'water image type is wrong';
						$this->debug($errorMsg);
				}//END SWITCH
			}else {
				$errorMsg			= 'water image is not exists';
				$this->debug($errorMsg);
			}//END IF
			$this->water_w				= $this->waterInfo[0];
			$this->water_h				= $this->waterInfo[1];
			$this->isWaterImg			= true;
			$this->imageWaterMark();
		}
		/**
		 * @param string $waterText 
		 * @param int $textFont
		 * @param string $textColor
		 */
		function setWaterFont($waterText, $textFont=5, $textColor='#FF0000', $ttfPath)
		{
			$this->waterText			= $waterText;
			$this->textFont				= $textFont;
			$this->textColor			= $textColor;
			$this->ttfPath				= $ttfPath;
			if(strlen($this->textColor) !== 7){
				$errorMsg				= 'text color value is wrong';
				$this->debug($errorMsg);
			}
			$temp			= imagettfbbox(ceil($this->textFont*2.5), 0 , $this->ttfPath, $this->waterText);
			$this->water_w				= $temp[2] - $temp[0];
			$this->water_h				= $temp[3] - $temp[5];
			unset($temp);
			$this->isWaterImg			= false;
			$this->imageWaterMark();
		}
		
		function imageWaterMark()
		{
			if ($this->base_w < $this->water_w || $this->base_h < $this->water_h){
				$errorMsg			= 'waterImg is bigger baseImg, waterMark is failing';
				$this->debug($errorMsg);
			}
			switch ($this->waterPos){
				case 0:
					$posX		= rand(0, ($this->base_w - $this->water_w));
					$posY		= rand(0, ($this->base_h - $this->water_h));
					break;
				case 1:
					$posX		= 0;
					$posY		= 0;
					break;
				case 2:
					$posX		= ($this->base_w - $this->water_w) / 2;
					$posY		= 0;
					break;
				case 3:
					$posX		= $this->base_w - $this->water_w;
					$posY		= 0;
					break;
				case 4:
					$posX		= 0;
					$posY		= ($this->base_h - $this->water_h) / 2;
					break;
				case 5:
					$posX		= ($this->base_w - $this->water_w) / 2;
					$posY		= ($this->base_h - $this->water_h) / 2;
					break;
				case 6:
					$posX		= $this->base_w - $this->water_w;
					$posY		= ($this->base_h - $this->water_h) / 2;
					break;
				case 7:
					$posX		= 0;
					$posY		= $this->base_h - $this->water_h;
					break;
				case 8:
					$posX		= ($this->base_w - $this->water_w) / 2;
					$posY		= $this->base_h - $this->water_h;
					break;
				case 9:
					$posX		= $this->base_w - $this->water_w;
					$posY		= $this->base_h - $this->water_h;
					break;					
			}//END SWITCH
			imagealphablending($this->baseImg, true);
			if($this->isWaterImg){
				imagecopy($this->baseImg, $this->waterImg, $posX, $posY, 0, 0, $this->water_w, $this->water_h);
			}else {
				$R = hexdec(substr($this->textColor,1,2));
				$G = hexdec(substr($this->textColor,3,2));
				$B = hexdec(substr($this->textColor,5));
				imagestring($this->baseImg, $this->textFont, $posX, $posY, $this->waterText, imagecolorallocate($this->baseImg, $R, $B, $G));
			}
			@unlink($this->baseImgPath);
			switch ($this->baseInfo[2]){
				case 1:
					imagegif($this->baseImg, $this->baseImgPath);break;
				case 2:
					imagejpeg($this->baseImg, $this->baseImgPath);break;
				case 3:
					imagepng($this->baseImg, $this->baseImgPath);break;
			}
		}

		function getDstImg()
		{
			return $this->baseImgPath;
		}
		
		function getErrorMsgs()
		{
			return $this->errorMsgs;
		}
		
		function debug($errorMsg)
		{
			$this->errorMsgs			.= $errorMsg;
			if($this->debug){
				exit($errorMsg);
			}else {
				return false;
			}
		}
		
		function __destruct()
		{
			unset($this->baseInfo);
			imagedestroy($this->baseImg);
			if(isset($this->waterInfo)){
				unset($this->waterInfo);
				imagedestroy($this->waterImg);
			}
		}
	}