<?php

class Form{

	private $XmlFile = './data/forms.xml';
	private $ErrorMessage = array();
	public  $i;
	public  $Lang;
	public  $FormArrayFlag = 0;
	private $FormArray = null;

	private $GroupFieldNum = array();


	public function &GetPostArray(){


		return $_POST;

	}
	public function &GetFormArray(){
		return $this->FormArray;
	}
	public function SetGroupFieldNum($GroupName,$Num){

		$this->GroupFieldNum["$GroupName"] = (int) $Num;


	}



	private $FormChecked = 0;


	public function &GetErrorsArray(){

		return $this->ErrorMessage;

	}

	function __construct($Lang){
		//todo: load some stuff here =)

		$this->Lang = $Lang;




	}
	function __destruct(){
		//		print '<br>';
		//		print("errors:  ");
		//		foreach ($this->ErrorMessage as $msg) {
		//			echo $msg.'<br>';

		//		}


	}



	public function &GetFormGroupsArray($FormName,$GroupName){

		$Lang = $this->Lang;
		$GroupArray = array();
		//open file with form data
		$xml = simplexml_load_file($this->XmlFile);
		if(!$xml) die('couldn\'t load form_data file!');

		//check if such form exists

		if(!$xml->$FormName) die("form loading error");//todo: redirect here

		foreach ($_POST as $key => $val){

			$Pattern = "/^".$GroupName."([0-9])_([0-9a-zA-Z-_]*)$/";

			preg_match($Pattern,$key,$matches);
			//preg_match($Pattern,'point0_point_id',$bla);

			if(!empty($matches)){

				if(get_magic_quotes_gpc()) $GroupArray[$matches[1]][$matches[2]] = $val;
				else $GroupArray[$matches[1]][$matches[2]] = addslashes($val);

			}

			unset($matches);
		}
		//var_dump($GroupArray);


		return $GroupArray;




	}
	
	private function ValidateField($FormFieldData,$Field,$Lang,$LoopIndex = 0){
	
			switch ($Field->type) {
				case 'string':
				$FormFieldData = (string) $FormFieldData;
				$Type = 'string';
				break;
				case 'int':
	//			$FormFieldData = (int) $FormFieldData;
				$Type = 'int';
				break;
				case 'float':
				$FormFieldData = (float) $FormFieldData;
				$Type = 'float';
				break;
				
				default:
				$Type = 'string';
				

			}

			//length check
				
				//print("<br>".$Field->id." , data $FormFieldData, ".$Field->length->min." , ".$Field->length->max .", $Field->type, $Type<br> ");
			if(($Type == 'string' ) && (!empty($Field->length->min) || !empty($Field->length->max)) ){
				if( (strlen($FormFieldData) < (int) $Field->length->min)  || (strlen($FormFieldData) > (int)$Field->length->max)){
				//		echo '<br> hm: '.$FormFieldData.', strlen is:'.strlen($FormFieldData).'max :'.$Field->length->max.' min:'. $Field->length->min;
					if(empty($Field->length->error_message->$Lang)) $this->InsertErrorMessage($Field->length->error_message->en);
					else $this->InsertErrorMessage($Field->length->error_message->$Lang);
				}
			}elseif( (($Type == 'int' ) || ($Type== 'float')) && (!empty($Field->length->min) || !empty($Field->length->max))){
			
				if($LoopIndex >0 ) $Msg = ", loop field #$LoopIndex";
				else $Msg = '';
				
				if($Type=='int' && !(is_numeric($FormFieldData))) $this->InsertErrorMessage("$Field->id error!".$Msg);
				
				if( ($FormFieldData < (int)$Field->length->min)  || ($FormFieldData > (int)$Field->length->max)){
					
					
				
					if(empty($Field->length->error_message->$Lang)) $this->InsertErrorMessage((string)$Field->length->error_message->en.$Msg);
					else $this->InsertErrorMessage((string)$Field->length->error_message->$Lang.$Msg);
				}
			
			}

			//regular expression check
			//	print("<br>".$Field->content->expr."<br>");
			//$Field->content->expr
			if(!empty($Field->content->expr)) {
				preg_match($Field->content->expr,$FormFieldData,$Match);

				if(!@$Match[0])
				{
					if(empty($Field->content->error_message->$Lang)){

						if(empty($Field->content->error_message->en))	$this->InsertErrorMessage('FormError!');
						else $this->InsertErrorMessage($Field->content->error_message->en);

					}else	$this->InsertErrorMessage($Field->content->error_message->$Lang);





				}

			}
	
	}

	public function ProceedForm($FormName){
		$Lang = $this->Lang;

		//open file with form data
		$xml = simplexml_load_file($this->XmlFile);
		if(!$xml) die('couldn\'t load form_data file!');

		//check if such form exists

		if(!$xml->$FormName) die("form loading error");//todo: redirect here


		foreach ($xml->$FormName->field as &$Field) {

		
			//			echo '<br>';
			//			print("field: ".$Field->id." POST: ".$_POST["$Field->id"]);

			

			if(!empty($Field->group)) {
				$Field->group = (string) $Field->group;
				
				if($this->GroupFieldNum["$Field->group"] == 0) continue;
				
				$Group = $Field->group;

				foreach ($xml->$FormName->groups->group as $XmlGroup) {

					if($XmlGroup->id == $Group ){

						if(empty($this->GroupFieldNum["$Group"])) {
							$this->InsertErrorMessage('Error procesing form, GroupNum error!');
							break 2;
						}

						for ($i=0;$i<($this->GroupFieldNum["$Group"]);$i++ ) {
						//		echo '<br>FormGroupId: ';
							$FormGroupId = $XmlGroup->id.$i.'_'.$Field->id;
							//	echo '<br>POST_DATA:';

							@$FormFieldData = &$_POST["$FormGroupId"];
							//	 print "<br> loop is $i <br><hr>";

							if((@$FormFieldData == null) && ((int)$Field->length->min > 0) ) {
								//echo $FormGroupId;
								//var_dump($_POST);
								$this->InsertErrorMessage("Error procesing form, group error on $i loop, $Field->id!");

								break 3;
							}
							
							if( !(empty($FormFieldData) && (int)$Field->length->min == 0))  $this->ValidateField($FormFieldData,$Field,$Lang,$i);





						}




					}



				}


			}else{

			//echo $Field->id.'/'.$Field->group.'<br>';
				
				@$FormFieldData = &$_POST["$Field->id"];
				
				if(((int) @$Field->notrequire == 1) && empty($FormFieldData))  $FormFieldData=0;
				 
				if(!@isset($FormFieldData))  {

					$this->InsertErrorMessage("Error procesing form!,$Field->id");
					break;
				}else{
					$this->ValidateField($FormFieldData,$Field,$Lang);
					if($this->FormArrayFlag == 1){
					
						$this->FormArray["$Field->id"] = $FormFieldData;
					
					}
				}
			}


			//type check
		

		}





	}

	private function InsertErrorMessage($Message){

		if(empty($this->i)) $this->i = 0;
		$this->ErrorMessage[$this->i]['msg'] = (string) $Message;
		$this->i++;


	}
	public function &GetField($FieldName){

		if(isset($_POST["$FieldName"])) {

			if (!get_magic_quotes_gpc()) $_POST["$FieldName"] =  addslashes($_POST["$FieldName"]);
			$ReturnValue = &$_POST["$FieldName"];

		}else $ReturnValue = null;

		return $ReturnValue;


	}

}

?>