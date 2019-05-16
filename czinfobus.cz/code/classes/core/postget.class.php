<?php

class CPostGetVars {

	function gvar($varname) {
		
		if( isset($_GET[$varname]) ) {
			return $_GET[$varname];
		}
		return false;
	}

	function pvar($varname) {
		
		if( isset($_POST[$varname]) ) {
			return $_POST[$varname];
		}
		return false;
	}

	function pgvar($varname) {
		$r = $this->pvar($varname);
		if( $r === false ) {
			$r = $this->gvar($varname);
		}
		return $r;
	}
	function UnsetVar($varname){
		unset($_GET[$varname]);
		unset($_POST[$varname]);
		
	
	}

}

$Pgvar = new CPostGetVars;

?>