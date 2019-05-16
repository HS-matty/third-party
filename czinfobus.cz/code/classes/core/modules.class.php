<?PHP
class Modules{


	//todo create fucntion IsObjectAccesseble($ModuleId,$ObjectId,$GroupId,$UserId);

	private $XmlFile = './data/modules.xml';

	private $Module = null;
	private $Object = null;
	private $ObjectParams = null;
	private $xml = 0;

	function __construct(){


	}
	
	public function AccessModulePage($UserObj, $ModuleObj, $PageObj = null){
		
		$IncludedAll = 0;
		$ExcludedAll = 0;
		$IncludedGroup = 0;
		
		$ExcludedGroup = 0;
		$IncludedUser = 0;
		$ExcludedUser = 0;
		
		
		$ObjectIncludedGroup = 0;
		$ObjectIncludedGroupAll = 0;
		$ObjectExcludedGroupAll = 0;
		$ObjectExcludedGroup = 0;
		$ObjectIncludedUser = 0;
		$ObjectExcludedUser = 0;
		
		
		
		
		
		if(!is_object($ModuleObj) || !is_object($UserObj)) return 0;
		
		$GroupId = $UserObj->Group;
		
		//check if users group is excluded from the module accepted groups
		foreach ($ModuleObj->grants->read->exclude->groups->group as $Group) {
			if($Group == $GroupId){
				
				$ExcludedGroup = 1;
	//			print("<br>ExGroup - $ExcludedGroup<br>");
			}		
		}

		//check if users group is exluded form the Object accepted groups
		//var_dump($PageObj);
		if(is_object($PageObj)){
		
			if((@$PageObj->grants->read->include->groups) == 'all'){
				$ObjectIncludedGroupAll = 1;
				//print("Obj Included all groups, $PageObj->id<br>");
			
			}
			
			if((string) trim(@$PageObj->grants->read->exclude->groups) == 'all'){
				$ObjectExcludedGroupAll = 1;
				//print("Obj Exlcuded all groups, $PageObj->id<br>");
			
			}
			
			if (@$PageObj->grants->read->include->users[0])
			foreach ($PageObj->grants->read->include->users->user as $User) {
				
				if((trim($User) == $UserObj->User)) $ObjectIncludedUser = 1;
				//print("<br>ObjIncUser - $User<br>");
								
			}
			if(@$PageObj->grants->read->exclude->users[0])
			foreach ($PageObj->grants->read->exclude->users->user as $User) {
				
				if(($User == $UserObj->User)) $ObjectExcludedUser = 1;
			//	print("<br>ObjExclUser - $User <br>");
								
			}
			if(@$PageObj->grants->read->exclude->groups[0])
			foreach ($PageObj->grants->read->exclude->groups->group as $Group) {
				
				if((trim($Group) == $GroupId)) $ObjectExcludedGroup = 1;
			//	print("<br>ObjExclGroup - $GroupId <br>");
								
			}
		//	var_dump($PageObj->grants->read);
			if (@$PageObj->grants->read->include->groups[0])
			foreach ($PageObj->grants->read->include->groups->group as $Group) {
				
				if((trim($Group) == $GroupId)) {
					$ObjectIncludedGroup = 1;
		//			print("<br>ObjInclGroup -".$GroupId."  <br>");
				}
								
			}
				
		
		}
		//svar_dump($this);
		
		//echo '<br> Included user:'.$IncludedUser.'<br>';
		
		//check if all groups are exluded from the module accepted groups
		if($ModuleObj->grants->read->exclude->groups == 'all'){
			$ExcludedAll = 1;
			//	print("<br>ExAlL - $ExcludedAll<br>");
			
		}
		
		//check if users group is included in the module accepted groups
		//var_dump($ModuleObj->grants->read->include->groups);
		
		foreach ($ModuleObj->grants->read->include->groups->group as $Group) {
			if($Group == $GroupId){
				
				$IncludedGroup = 1;
		
			//	print("<br>InclGroup - $IncludedGroup, $Group, $GroupId, $ModuleObj->id <br>");
			}		
		}
			
		//check if all groups are included in the module accepted groups
		
		if($ModuleObj->grants->read->include->groups == 'all'){
			
			$IncludedAll = 1;
		//	print("<br>InclAll - $IncludedAll, $ModuleObj->id <br>");
		}
			
		
		
	//bb	print "inc: $IncludedGroup<br>";
		if($ExcludedGroup || $ObjectExcludedGroup) {
		
			$ReturnValue = 0;
		}
		else{
			//var_dump($UserObj);
			//echo '<br>'.$IncludedGroup.$ObjectIncludedGroup.'<br>';
			
			if( ($IncludedGroup && ($ObjectIncludedGroup || ($ObjectIncludedGroupAll && !$ObjectExcludedGroup)) )) $ReturnValue = 1;
			elseif (($IncludedAll) && (!$ExcludedGroup) && ($ObjectIncludedGroup || ($ObjectIncludedGroupAll && !$ObjectExcludedGroup))) $ReturnValue = 1;
			else $ReturnValue = 0;
//		print "<br> return : $ReturnValue <br>";
		
		}
		//echo $ReturnValue;
		return $ReturnValue;
		
		
	}
	public function &GetModule(){
		return $this->Module;
	}

	public function GetObject(){

		return $this->Object;
	}


	public function &GetUserAvailableModules($User){
		global $InOut;
		if(!is_object($InOut)) die('internal error!');
		$Lang = $InOut->InLang;
		
		$Mods = array();
		
		
		$xml = simplexml_load_file($this->XmlFile);
		$i = 0;

		foreach ($xml->module as $XmlModule) {
			if(!empty($XmlModule->not_public)) continue;
				
//			print "module is: $XmlModule->id,".$XmlModule->grants->read->include->groups."<br>";
			$Excluded = 0;
			$Included = 0;
			$ExcAll = 0;
			$IncAll = 0;

			if(@( trim( (string)$XmlModule->grants->read->exclude->groups) == 'all')) $ExcAll = 1;
			
			$r = @$XmlModule->grants->read->exclude->groups->children();
			
			if(!empty($r)){


				foreach ($XmlModule->grants->read->exclude->groups->group  as $Group) {
			//		print "<br> $Group, $User->Group <br>";	
					if(trim($Group) == $User->Group) $Excluded = 1;
				}
			}
			
			if(!$Excluded){
				
				//echo $XmlModule->grants->read->include->groups.'<br>';
				$GroupAll = (string)$XmlModule->grants->read->include->groups;
				
				$GroupAll = trim($GroupAll);
				
				if(!strcmp($GroupAll,'all')) {
			//		echo $XmlModule->id.'zzzzzzzzzzzzzzzz<br>';
					$IncAll = 1;
										
				}
				//echo 'All:'.$IncAll.',.'.$XmlModule->grants->read->include->groups.'<br>';
				$s = @$XmlModule->grants->read->include->groups->children();
				if($s) {

					foreach (@$XmlModule->grants->read->include->groups->group  as $Group) {

						if($Group == $User->Group)  $Included= 1;
					}


				}

			}
			
			if( ($IncAll) && ($Excluded == 0)) $Included = 1;
			
			if($Included) {
				$Mods[$i]['id'] = (string) $XmlModule->id;
				$Mods[$i]['url'] = $InOut->GenerateFullUrl($XmlModule->id,'index',$Lang,0,$InOut->InSid);
				if(empty($XmlModule->name->$Lang)) $Mods[$i]['name'] =  (string) $XmlModule->name->en;
				else $Mods[$i]['name'] =  (string) $XmlModule->name->$Lang;
				$i++;
				

			}

		}
	
		return $Mods;		
	}
	public function &GetUserObjects($User, $Module){
		
		//die('dededeeede');
		global $InOut;
		$Lang = $InOut->InLang;
		$xml = simplexml_load_file($this->XmlFile);
				
//		if(!is_object($Module) || !is_object($User)) return 0;
		$i = 0;
		$Obj = array();
		foreach ($Module->objects->object as $Object) {
			
			$IncludedGroup = 0;
			$ExcludedGroup = 0;
			$IncludedAll = 0;
			$ExcludedAll = 0;
			
			if( ((int) $Object->public == 1)){
				
				if(trim($Object->grants->read->include->groups) == 'all') $IncludedAll = 1;
				if(trim($Object->grants->read->exclude->groups) == 'all') $ExcludedAll = 1;
				
				foreach ($Object->grants->read->include->groups->group as $Group) {
					
					if($User->Group == $Group) {
						$IncludedGroup = 1;
						break;
						
					}
					
					
				}
				
				foreach ($Object->grants->read->exclude->groups->group as $Group) {
					
					if($User->Group == $Group) {
						$ExcludedGroup = 1;
						break;
						
					}
					
					
				}
				
				
			
			}

			if($IncludedGroup || ($IncludedAll && !$ExcludedGroup) ) {
				$Obj[$i]['id'] = (string) $Object->id;
				$Obj[$i]['url'] = $InOut->GenerateFullUrl($Module->id,$Object->id,$Lang,0,$InOut->InSid);
				if(empty($Object->name->$Lang)) $Obj[$i]['name'] =  'Unnnamed object';
				else $Obj[$i]['name'] =  (string) $Object->name->$Lang;
				$i++;
				

			}		
			
		}
		//var_dump($Obj);
		return $Obj;
		
	
	}
	
	
	public function GetDataByAlias($Alias,$Lang, $PublicFlag = 1){

		$ReturnValue = 1;
	//	echo $Alias.'<br>';

		$xml = simplexml_load_file($this->XmlFile);

		foreach ($xml as $XmlModule) {

			foreach ($XmlModule->objects->object as $XmlObject) {


				foreach (@$XmlObject->alias_list->alias as $XmlAlias) {
		//			echo $XmlAlias->id.'<br>';
					
					if( (string)$XmlAlias->id == $Alias) {

						$this->Module =  $XmlModule;
						$this->Object = $XmlObject;
						if(!empty($XmlAlias->params->$Lang))  $XmlObject->param = (string) $XmlAlias->params->$Lang;
						
						$ReturnValue = 0; //found
						break 3;
					}

				}


			}
		}


		return $ReturnValue;


	}


	public function GetDataByParams($Module,$Object){

		$ReturnValue = 1;
		$xml = simplexml_load_file($this->XmlFile);

	//	print("mod: $Module, obj = $Object");

		//if(empty($xml->$Module->$Object)



		//	var_dump($xml);




		foreach ($xml as $XmlModule) {

			if($XmlModule->id == $Module) {
				$this->Module =  $XmlModule;


				foreach ($XmlModule->objects->object as $XmlObject) {

					if($XmlObject->id == $Object) {
						$this->Object = $XmlObject;


						break 2;
					}

				}

			}

		}

	}
}


?>