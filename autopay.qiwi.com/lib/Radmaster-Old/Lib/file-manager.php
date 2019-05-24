<?php
/*
radMaster Framework 2.2
(c) Sergey Volchek 2003-2007
You can freely use this file
if you have any questions please visit www.radmaster.net

*/

class FileManager{


	public $CurrentFileType;
	public $PredefinedTypes = array();
	public $UploadedFile;
	public $MovedFile;
	private $FileTitle; //
	private $File;
	public  $Path;


	function __construct(){

		$Image = array('image/png','image/x-ms-bmp','image/tiff','image/gif','image/x-png','image/pjpeg','image/jpeg','gif','png','bmp','tiff');
		//	array_push($this->PredefinedTypes,array('image'=>$Image));
		$this->PredefinedTypes['image'] = $Image;


	}

	public function isFileUploaded($FileTitle){

		if(@empty($_FILES[$FileTitle]['name'])) return false;
		return true;

	}

	private function checkFileType($PredifedType,$UploadedFileType){

		$return_value = false;
		foreach ($this->PredefinedTypes["$PredifedType"] as $Type){
			//echo $Type.'-'.$UploadedFileType.'<br>';
			if($Type == $UploadedFileType) {

				$return_value = true;
			}
		}
		return $return_value;


	}
	public function checkUploadedFile($FileTitle,$Type,$MinSize = 1, $MaxSize = 100000){
		//		 		print_r($_FILES);

		//if( empty($_FILES[$FileTitle]['name']) || !$this->checkFileType($Type,$_FILES[$FileTitle]['type'])) return false;

		//empty($_FILES[$FileTitle]['name']);
		$this->FileTitle = $FileTitle;
		$this->File = $_FILES[$FileTitle]['name'];
		$this->UploadedFile = $_FILES[$FileTitle]['tmp_name'];
		return true;



	}
	public function moveUploadedFile($ToDir,$ToFile = null){

		//todo make path check

		if(!$ToFile) $ToFile = $this->File;

		global $Config;

		$FileArr = split('\.',$ToFile,2);




		//$ToDir = $Config->SitePath.$ToDir;

		$i='';
		
		//changed the way of uploading - instead of initial name, md5 rand hash is used
		
/*		while (true){
			if(file_exists($ToDir.$FileArr[0].$i.'.'.$FileArr[1]))	{
				$i++;

			}else {
				$this->Path = $ToDir;
				copy($this->UploadedFile,$ToDir.$FileArr[0].$i.'.'.$FileArr[1]);
				break;

			}

			if($i > 9999) throw new Exception('Uploading file error');

		}*/
	
		
		$this->Path = $ToDir;
		//get random md5
		//$NewFileName = md5(time().rand().$FileArr[0]).'.'.$FileArr[1];
		
		$NewFileName = $ToFile;
		copy($this->UploadedFile,$ToDir.$NewFileName);


		//	echo $ToDir.$FileArr[0].$i.'.'.$FileArr[1];
		return  	 $this->MovedFile = $NewFileName;



	}
	public function makeThumbnail($sourceimg, $destimg, $twidth, $theight,$rotate=false){


	
	
	

	
	
	
	
		list($width, $height, $type, $attr) = getimagesize($sourceimg);

		
		
		
		
		

		if(!$width) return false;

		if ($type == 2) $im = imagecreatefromjpeg ($sourceimg);

		if ($type == 1) $im = imagecreatefromgif ($sourceimg);

		if ($type == 3) $im = imagecreatefrompng ($sourceimg);



		$im2 = imagecreatetruecolor($twidth,$theight);



		$bgcolor = imagecolorallocate ($im2, 255, 255, 255);

		$black = imagecolorallocate ($im2, 0, 0, 0);

		imagefill($im2, 0,0, $bgcolor);



		if ($width != $twidth || $height != $theight){

			$k = 1;

			//if ($height > $width)

			//print ($height).'----'.($width);die;

			//print ($height/$width).'----'.($theight/$twidth);die;

			if (($height/$width)>($theight/$twidth))

			{

				$k = $height/$theight;

				imagecopyresized ($im2, $im, round(($twidth/2)-($width/($k*2))), 0, 0, 0, ceil($width/$k), $theight, $width, $height);

			}

			else

			{

				$k = $width/$twidth;

				imagecopyresized ($im2, $im, 0, round(($theight/2)-($height/($k*2))), 0, 0, $twidth, ceil($height/$k), $width, $height);

			}

		} else {

			imagecopyresized ($im2, $im, 0, 0, 0, 0, $width, $height, $width, $height);

		}

		if ($rotate)$im2 = imagerotate($im2, 90, 0);


		imagepng($im2, $destimg);
		
		imagedestroy($im);
		imagedestroy($im2);
		@chmod($destimg, 0777);

		return true;

	}




}

?>