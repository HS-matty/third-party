<?php

function mysql_fetch_fields($table) {
	// LIMIT 1 means to only read rows before row 1 (0-indexed)
	$result = mysql_query("SELECT * FROM $table LIMIT 1");
	$describe = mysql_query("SHOW COLUMNS FROM $table");
	$num = mysql_num_fields($result);
	$output = array();
	for ($i = 0; $i < $num; ++$i) {
		$field = mysql_fetch_field($result, $i);
		// Analyze 'extra' field
		$field->auto_increment = (strpos(mysql_result($describe, $i, 'Extra'), 'auto_increment') === FALSE ? 0 : 1);
		// Create the column_definition
		$field->definition = mysql_result($describe, $i, 'Type');
		if ($field->not_null && !$field->primary_key) $field->definition .= ' NOT NULL';
		if ($field->def) $field->definition .= " DEFAULT '" . mysql_real_escape_string($field->def) . "'";
		if ($field->auto_increment) $field->definition .= ' AUTO_INCREMENT';
		if ($key = mysql_result($describe, $i, 'Key')) {
			if ($field->primary_key) $field->definition .= ' PRIMARY KEY';
			else $field->definition .= ' UNIQUE KEY';
		}
		// Create the field length
		$field->len = mysql_field_len($result, $i);
		// Store the field into the output
		$output[$field->name] = $field;
	}
	return $output;
}

function 	ping($host){

	if( !preg_match('/^[a-z]+\.[a-z]+$/',$host)) die('bad syntax');

	//	$trace =   shell_exec('tracert '.$host);
	//	exec("ping -n 1 -w 200 $ip",$output, $status);
	exec("ping -n 1 -w 200 $ip",$output, $status);
	$trace = nl2br($trace);
	echo $trace;
}


function validate_email($email)
{
	// Create the syntactical validation regular expression
	$regexp = "^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$";
	// Presume that the email is invalid
	$valid = 0;
	// Validate the syntax
	if (eregi($regexp, $email))
	{
		//	list($username,$domaintld) = split("@",$email);
		// Validate the domain
		//	if (getmxrr($domaintld,$mxrecords)){

		$valid = 1;
	} else {
		$valid = 0;
	}
	return $valid;
}

/**
    * Remove a value from a array

    */
function array_remval(&$arr,$key = null,$val = null)
{


	$array_remval = $arr;
	for($x=0;$x<count($array_remval);$x++)
	{
		$i = $key;
		if($val) $i=array_search($val,$array_remval);
		if (is_numeric($i)) {
			$array_temp  = array_slice($array_remval, 0, $i );
			$array_temp2 = array_slice($array_remval, $i+1, count($array_remval)-1 );
			$array_remval = array_merge($array_temp, $array_temp2);
		}
	}



	return $array_remval;
}


function html_to_utf8_tiny ($data)
{
	return preg_replace("/\\&\\#([0-9]{3,10})\\;/e", '_html_to_utf8("\\1")', $data);
}

function html_to_utf8 ($data)
{
	if ($data > 127)
	{
		$i = 5;
		while (($i--) > 0)
		{
			if ($data != ($a = $data % ($p = pow(64, $i))))
			{
				$ret = chr(base_convert(str_pad(str_repeat(1, $i + 1), 8, "0"), 2, 10) + (($data - $a) / $p));
				for ($i; $i > 0; $i--)
				$ret .= chr(128 + ((($data % pow(64, $i)) - ($data % ($p = pow(64, $i - 1)))) / $p));
				break;
			}
		}
	}
	else
	$ret = "&#$data;";
	return $ret;
}


function _escape($string, $esc_type = 'html', $char_set = 'ISO-8859-1')
{
	switch ($esc_type) {
		case 'html':
			return htmlspecialchars($string, ENT_QUOTES, $char_set);

		case 'htmlall':
			return htmlentities($string, ENT_QUOTES, $char_set);

		case 'url':
			return rawurlencode($string);

		case 'urlpathinfo':
			return str_replace('%2F','/',rawurlencode($string));

		case 'quotes':
			// escape unescaped single quotes
			return preg_replace("%(?<!\\\\)'%", "\\'", $string);

		case 'hex':
			// escape every character into hex
			$return = '';
			for ($x=0; $x < strlen($string); $x++) {
				$return .= '%' . bin2hex($string[$x]);
			}
			return $return;

		case 'hexentity':
			$return = '';
			for ($x=0; $x < strlen($string); $x++) {
				$return .= '&#x' . bin2hex($string[$x]) . ';';
			}
			return $return;

		case 'decentity':
			$return = '';
			for ($x=0; $x < strlen($string); $x++) {
				$return .= '&#' . ord($string[$x]) . ';';
			}
			return $return;

		case 'javascript':
			// escape quotes and backslashes, newlines, etc.
			return strtr($string, array('\\'=>'\\\\',"'"=>"\\'",'"'=>'\\"',"\r"=>'\\r',"\n"=>'\\n','</'=>'<\/'));

		case 'mail':
			// safe way to display e-mail address on a web page
			return str_replace(array('@', '.'),array(' [AT] ', ' [DOT] '), $string);

		case 'nonstd':
			// escape non-standard chars, such as ms document quotes
			$_res = '';
			for($_i = 0, $_len = strlen($string); $_i < $_len; $_i++) {
				$_ord = ord(substr($string, $_i, 1));
				// non-standard char, escape it
				if($_ord >= 126){
					$_res .= '&#' . $_ord . ';';
				}
				else {
					$_res .= substr($string, $_i, 1);
				}
			}
			return $_res;

		default:
			return $string;
	}
}

function get_ip_list($asString = false) {
	$tmp = array();
	if  (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && strpos($_SERVER['HTTP_X_FORWARDED_FOR'],',')) {
		$tmp +=  explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
	} elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$tmp[] = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	$tmp[] = $_SERVER['REMOTE_ADDR'];
	if($asString && $tmp){
		$str ='';
		foreach ($tmp as &$val) $str .= $val.' ';
		return $str;
	}
	return $tmp;
}

function write_to_file($file,$text){

	//$Path = "d:\\work\\root\\bus\\www\\logs1234\\";

	//$today = date("j.n.Y - H:i");

	//$Message = "$today : $Message\n";
	if(is_array($text)){
		$array_text = '';
		foreach ($text as $line) $array_text .= $line.'\n\r';
		$text =& $array_text;
	}

	$handle = fopen($file, 'a');
	if($handle) $flag = fwrite($handle,$text);
	else  $flag = false;
	return $flag;

}

function trim_first_last_char($string){

	$string = trim($string);
	$length = strlen($string);

	$string = substr($string,1);
	$string = substr($string,0,$length-2);

	return $string;

}

function generatePassword ($passwordLength, $characterSet)
{
	//Random password generator if anyone needs one
	//B Palmer 2007 - Distribute, manipulate, just dont sell, not that its worth anything anyway!

	//Character Sets
	//1 - numbers only (48[0] to 57[9]) - 10
	//2 - lowercase only (97[a] to 122[z]) - 26
	//3 - uppercase only (65[A] to 90[Z]) - 26
	//4 - lowercase (97[a] to 122[z]) + uppercase (65[A] to 90[Z]) - 52
	//5 - lowercase (97[a] to 122[z]) + uppercase (65[A] to 90[Z]) + numbers (48[0] to 57[9]) - 62
	//6 - full keyboard set (32 to 126) less space (32[space], 34["], 39['], 96[`]) - 91


	//1 - numbers only (48[0] to 57[9]) - 10
	if($characterSet==1)
	{
		$passwordString = "";
		for($i=0; $i<$passwordLength; $i++)
		{
			$selectedChar = rand(0, 9);
			$passwordString .= $selectedChar;
		}
	}

	//2 - lowercase only (97[a] to 122[z]) - 26
	if($characterSet==2)
	{
		$passwordString = "";
		for($i=0; $i<$passwordLength; $i++)
		{
			$selectedChar = rand(97, 122);
			$selectedChar = chr($selectedChar);
			$passwordString .= $selectedChar;
		}
	}

	//3 - uppercase only (65[A] to 90[Z]) - 26
	if($characterSet==3)
	{
		$passwordString = "";
		for($i=0; $i<$passwordLength; $i++)
		{
			$selectedChar = rand(65, 90);
			$selectedChar = chr($selectedChar);
			$passwordString .= $selectedChar;
		}
	}

	//4 - lowercase (97[a] to 122[z]) + uppercase (65[A] to 90[Z]) - 52
	if($characterSet==4)
	{
		$passwordString = "";
		for($i=0; $i<$passwordLength; $i++)
		{
			$selectedChar = rand(1, 52);
			if($selectedChar>=1&&$selectedChar<=26)
			{
				$selectedChar = $selectedChar + 64;
				$selectedChar = chr($selectedChar);
			}
			else
			{
				$selectedChar = $selectedChar + 70;
				$selectedChar = chr($selectedChar);
			}
			$passwordString .= $selectedChar;
		}
	}

	//5 - lowercase (97[a] to 122[z]) + uppercase (65[A] to 90[Z]) + numbers (48[0] to 57[9]) - 62
	if($characterSet==5)
	{
		$passwordString = "";
		for($i=0; $i<$passwordLength; $i++)
		{
			$selectedChar = rand(1, 62);
			if($selectedChar>=1&&$selectedChar<=10)
			{
				$selectedChar = $selectedChar + 47;
				$selectedChar = chr($selectedChar);
			}
			elseif($selectedChar>=11&&$selectedChar<=36)
			{
				$selectedChar = $selectedChar + 54;
				$selectedChar = chr($selectedChar);
			}
			else
			{
				$selectedChar = $selectedChar + 60;
				$selectedChar = chr($selectedChar);
			}
			$passwordString .= $selectedChar;
		}
	}

	//6 - full keyboard set (32 to 126) less space (32[space], 34["], 39['], 96[`]) - 91
	if($characterSet==6)
	{
		$passwordString = "";
		for($i=0; $i<$passwordLength; $i++)
		{
			$selectedChar = rand(1, 91);
			if($selectedChar==1)
			{
				$selectedChar = $selectedChar + 32;
				$selectedChar = chr($selectedChar);
			}
			elseif($selectedChar>=2&&$selectedChar<=5)
			{
				$selectedChar = $selectedChar + 33;
				$selectedChar = chr($selectedChar);
			}
			elseif($selectedChar>=6&&$selectedChar<=61)
			{
				$selectedChar = $selectedChar + 34;
				$selectedChar = chr($selectedChar);
			}
			else
			{
				$selectedChar = $selectedChar + 35;
				$selectedChar = chr($selectedChar);
			}
			$passwordString .= $selectedChar;
		}
	}

	return $passwordString;
}


function microtime_float()
{
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}


function _is_array($var){
	
	 return (bool)($var instanceof ArrayAccess or is_array($var));
}


function uchr ($codes) {
    if (is_scalar($codes)) $codes= func_get_args();
    $str= '';
    foreach ($codes as $code) $str.= html_entity_decode('&#'.$code.';',ENT_NOQUOTES,'UTF-8');
    return $str;
}


/*function setClassConstValue($class_name,$constant_name,$value){


$ref = new ReflectionClass($class_name);



}*/
?>