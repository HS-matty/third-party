<?php


class Rad_File{
	
	public $Filename;
	public $Path;
	public $FileType;
	
	function __construct(){
		$this->Filename = '';
		$this->Path = '';
		$this->FileType = '';
	}
	
	function init($Id){
		
		if($_FILES[$Id]){
			
/*			print_r($_FILES);
			die();*/
			$this->Path  = '/images/test/';
			$this->FileType  = 'image';
			
			
		}
		
		
		
	}
	
	
}
?>