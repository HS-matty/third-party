<?php

/*****************************************************************************/
/* cTemplate - template parser                                               */
/* Version: 3.4                                                              */
/* First release: may 2002                                                   */
/* Last update: 08 sep 2004                                                  */
/* Author: Sergey Drobishevsky                                               */
/* Email: clusta@mail.ru                                                     */
/*                                                                           */
/* Change log (imp=improvement, fix=bugfix, chg=changes):                    */
/* 05.12.03 imp: engine rewritten to recursive parsing                       */
/* 06.09.04 fix: nested loops not parsed correctly                           */
/* 08.09.04 imp: added 2 new tags: COUNT and REM                             */
/*   imp: new variable modifier added: PARENT, used for access               */
/*        variables from a parent loop in the nested loop                    */
/*   fix: skip warnings about non-exist variables within non-printed         */
/*        IF, ELSE, ELSEIF sections                                          */
/*   fix: parsing of tags like <%elseif%> was incorrectly detected as ELSE   */
/*        with parameter "IF"                                                */
/*   fix: LOOP:ITERATION and others not worked in ELSE and ELSEIF sections   */
/*   fix: parsing of hexadecimal numbers in the expressions                  */
/*   fix: bitwise operators not works correctly on numbers stored in params  */
/*        as strings                                                         */
/*   imp: combinations like parent:parent:var or parent:parent:loop:count    */
/*        now allowed                                                        */
/*   chg: enable_eval_errors now TRUE by default                             */
/*   imp: COUNT now used as count:arrayname. Can be used with parent: and    */
/*        global: and in expressions like count:arrayname+2                  */
/*        NOTE: all parameters like count:myvariable assigned to template    */
/*        class param array will be deleted and ignored. To avoid potential  */
/*        problems in the future do not use : in parameters names.           */
/* 09.09.04 imp: added IFSET tag - checks for variable existense             */
/* 13.09.04 fix: ELSEIF not working correctly                                */
/*                                                                           */
/*                                                                           */
/*****************************************************************************/

class cTemplate {

	var $template_contents;
	var $param;
	var $max_includes = 10;
	var $inc_dir;
	var $file_name;
	var $tags = array(
			0 => 'loop',
			1 => 'endloop',
			2 => 'if',
			3 => 'endif',
			4 => 'else',
			5 => 'elseif',
			6 => 'ifset',
			49 => 'include',
			50 => 'echo',
			51 => 'echohtml',
			52 => 'rem'
		    );
	var $otag ='<%';
	var $ctag ='%>';

	// Warnings:
	//  0x0001 - Invalid expression definition: closing double quote not found
	//  0x0002 - Unknown tag
	//  0x0004 - Tag not closed
	//  0x0008 - Unexpected tag (e.g. ENDIF without preceding IF)
	//  0x0010 - Expressions not allowed (e.g. in ELSE tag)
	//  0x0100 - Undefined parameter in expression


	var $disable_warnings;
	var $enable_eval_errors;

function fatal($msg) {
	$Msg =  "<b>[Template, ".$this->file_name."] Error:</b> ".$msg;
	CLog::FileLog('tmpl.txt',$Msg);
	print("Template error! Exiting!<br>$Msg");
	
	exit;
	
}

function warning($wmask,$code,$val='') {

	if( !($this->disable_warnings & $wmask) ) {
		$code = htmlspecialchars($code);
		if( !is_array($val) ) $val = htmlspecialchars($val);
		switch( $wmask ) {

		  // global warnings

		  case 0x1:
			$msg = "Invalid expression definition: closing double quote not found near \"".$code."...\" - tag ignored<br>\n";
			break;
		  case 0x2:
			$msg = "Unknown tag near \"".$code."...\" - tag ignored<br>\n";
			break;
		  case 0x4:
			$msg = "Tag not closed near \"".$code."...\" - tag ignored<br>\n";
			break;
		  case 0x8:
			$msg = "Unexpected <b>".$val."</b> tag near \"".$code."...\" - tag ignored<br>\n";
			break;
		  case 0x10:
			$msg = "Invalid <b>".$val."</b> tag - expressions not allowed near \"".$code."...\" - expression ignored<br>\n";
			break;
		  case 0x20:
			$msg = "Variable name not given in <b>".$val."</b> tag near \"".$code."...<br>\n";
			break;

		  // expression warnings

		  case 0x100:
			$msg = "Undefined parameter <b>".$val."</b> in expression near \"".$code."...\" - assuming NULL<br>\n";
			break;
		  case 0x200:
			$msg = "Assuming empty array for loop iteration due to non-array element type. Iteration: ".htmlspecialchars($val[0]).", key: ".htmlspecialchars($val[1])."<br>\n";
			break;

		  // unknown warning

		  default:
			$msg = "Unknown warning near \"".$code."...\"";
			break;
		}
		
		$Message =  "<b>[Template, ".$this->file_name."] Warning:</b> ".$msg;
		CLog::FileLog('tmpl.txt',$Message);
		print("Template warning! $Message");
		
	}
}

function cTemplate($filename,$options=array()) {
	$param = array();
	$fh = @fopen($filename,"rb");
	if( !$fh ) $this->fatal("Failed opening file '".$filename."'",1);
	$this->template_contents = fread ($fh, filesize ($filename));
	@fclose ($fh);
	$this->inc_dir = dirname($filename).'/';
	$this->file_name = $filename;
	if( isset($options['disable_warnings']) ) {
		$this->disable_warnings = $options['disable_warnings'];
	} else {
//		$this->disable_warnings = 2 | 0x100;
		$this->disable_warnings = 0;
	}
	if( isset($options['enable_eval_errors']) &&
	    !$options['enable_eval_errors'] ) {
		$this->enable_eval_errors = false;
	} else {
		$this->enable_eval_errors = true;
	}
}

function param($key,$val) {
	$this->param[trim(strtolower($key))] = $val;
	return true;
}

/*

Expressions syntax:

varname - get var from current scope;
global:varname - get var from global parameters;
parent:varname -  get var from parent loop;
loop:paramname - get loop parameter;
count:arrayname - get number of elements in the given array

allowed combinations:

parent:parent:paramname
parent:parent:parent:paramname
...
parent:loop:paramname
parent:parent:loop:paramname
...
parent:count:arrayname
parent:parent:count:arrayname
...
global:count:arrayname

Rest of the string must be valid PHP expression without ' and ".

*/

function parse_expr($e,$param,$options=array()) {

	if( (isset($options['skip_result']) && $options['skip_result'])
	    ||
	    (isset($options['subtag_id']) &&
	     (($options['subtag_id'] == 3) || ($options['subtag_id'] == 6)) &&
	     (!isset($options['if_result']) ||
	      (isset($options['if_result']) && !$options['if_result']))) )
		return false;

	$expr = $e;

	$pos = 0;
	while( $pos<strlen($e) ) {
	  if( ($e[$pos] >= '0') && ($e[$pos] <= '9') ) {

		$pos2 = $pos+1;
		if( ($pos2 < strlen($e)) &&
		    (($e[$pos2] == 'x') || ($e[$pos2] == 'X')) ) {
			// hexadecimal
			$pos2++;
			while( $pos2 < strlen($e) ) {
				if( !((($e[$pos2] >= 'a') && ($e[$pos2] <= 'f')) ||
				      (($e[$pos2] >= 'A') && ($e[$pos2] <= 'F')) ||
				      (($e[$pos2] >= '0') && ($e[$pos2] <= '9'))) )
					break;
				$pos2++;
			}
			if( ($pos2 < strlen($e)) &&
			    ((($e[$pos2] >= 'a') && ($e[$pos2] <= 'z')) ||
			     (($e[$pos2] >= 'A') && ($e[$pos2] <= 'Z'))) )
				$this->fatal('Expression <b>'.htmlspecialchars($expr).'</b> error near "'.
					htmlspecialchars(substr($e,$pos,30))."...\"<br>\n");
		} else {
			// decimal or octal
			while( $pos2<strlen($e) ) {
				if( !(($e[$pos2] >= '0') && ($e[$pos2] <= '9')) )
					break;
				$pos2++;
			}
		}
		$pos = $pos2;
		continue;
	  }

	  if( (($e[$pos] >= 'a') && ($e[$pos] <= 'z')) ||
	      (($e[$pos] >= 'A') && ($e[$pos] <= 'Z')) ) {

		$pos2 = $pos+1;
		$s = $e[$pos];

		while( $pos2<strlen($e) ) {
			if( (($e[$pos2] >= 'a') && ($e[$pos2] <= 'z')) ||
			    (($e[$pos2] >= 'A') && ($e[$pos2] <= 'Z')) ||
			    (($e[$pos2] >= '0') && ($e[$pos2] <= '9')) ||
			    ($e[$pos2] == '_') || ($e[$pos2] == ':') ) {
				$s .= $e[$pos2];
				$pos2++;
				continue;
			}

			break;
		}

		$var = '';

		if( !isset($param[strtolower($s)]) ) {
			$this->warning(0x100,substr($e,$pos,30),$s);
			$var = "NULL";
		} else {
			if( is_numeric($param[strtolower($s)]) ) {
				$var = $param[strtolower($s)];
			} else {
				$var = '$param[\''.strtolower($s)."']";
			}
		}

		$e = substr($e,0,$pos).$var.substr($e,$pos2);
		$pos += strlen($var);
		continue;
	  }

	  if( (strlen($e) > $pos+2) &&
	      in_array(substr($e,$pos,3),array("===","!==")) ) {
		$pos += 3;
		continue;
	  }

	  if( (strlen($e) > $pos+1) &&
	      in_array(
		substr($e,$pos,2),
		array("||","&&","==","!=","<=",">=","<<",">>","++","--")
	      ) ) {
		$pos += 2;
		continue;
	  }

	  if( strpos(chr(9).' []()|^&<>+-*./%!~?:',$e[$pos]) !== false ) {
		$pos++;
		continue;
	  }

	  $this->fatal('Expression <b>'.htmlspecialchars($expr).'</b> error near "'.
		htmlspecialchars(substr($e,$pos,30))."...\"<br>\n");
	}

	$e = 'return '.$e.';';
	if( $this->enable_eval_errors ) {
		$result = eval($e);
	} else {
		$result = @eval($e);
	}
//echo $e;
//echo "Result type: ".gettype($result)."<br>\n";
//echo "Result: $result<br>\n";

	return $result;
}

function &parse_whole($tc,$param=false,$options=array()) {

	if( $param===false ) $param=$this->param;

	$subtag_id = isset($options['subtag_id']) ? $options['subtag_id'] : false;
	$skip_result = isset($options['skip_result']) ? $options['skip_result'] : false;
	$if_result = isset($options['if_result']) ? $options['if_result'] : false;

	$spos = 0;

	while( true ) {

		// case-insensitive open tag search
//		$tag_str = stristr(substr($tc,$spos),$this->otag);
//		if( $tag_str == '' ) break;
//		$pos_otag = strlen($tc)-strlen($tag_str);

		// case-sensitive open tag search
		$pos_otag = strpos($tc,$this->otag,$spos);
		if( $pos_otag===false ) break;

		// try to identify tag
		$known_tag = false;
		foreach( $this->tags as $i => $tag ) {
		  if( (strcasecmp($tag,substr($tc,$pos_otag+strlen($this->otag),strlen($tag)))==0) &&
		      (($known_tag === false) ||
		       (strlen($this->tags[$known_tag-1]) < strlen($tag)) ) ) {
			$known_tag = $i+1;
		  }
		}

		if( $known_tag === false )
		  $this->warning(0x2,substr($tc,$pos_otag,30));

		// identify expression within a tag
		$expr = false;
		if( $known_tag !== false ) {
		  $tpos = $pos_otag + strlen($this->otag) + strlen($this->tags[$known_tag-1]);

		  // skip spaces and tabs
		  while( ($tpos<strlen($tc)) &&
			 (($tc[$tpos]==chr(9)) || ($tc[$tpos]==' ')) ) $tpos++;

		  if( strcasecmp(substr($tc,$tpos,strlen($this->ctag)),$this->ctag) == 0 ) {
		    // closing tag found
		    $pos_ctag = $tpos;
		  } elseif ( $tc[$tpos] == '"' ) {
		    // expression started within double quotes

		    $tpos++;
		    $pos_expr = $tpos;

		    if( ($tpos = strpos($tc,'"',$tpos)) !== false ) {
			$expr = trim(substr($tc,$pos_expr,$tpos-$pos_expr));

		      // closing double quote found - search for closing tag

		      $tpos++;
		      // skip spaces and tabs
		      while( ($tpos<strlen($tc)) &&
			     (($tc[$tpos]==chr(9)) || ($tc[$tpos]==' ')) )
			$tpos++;

		      if( strcasecmp(substr($tc,$tpos,strlen($this->ctag)),$this->ctag) == 0 ) {
		        // closing tag found
		        $pos_ctag = $tpos;
		      } else {
		        // unable to find closing tag - skip whole tag
			$this->warning(0x4,substr($tc,$pos_otag,30));
		        $known_tag = false;
		      }

		    } else {
		      // closing double quote not found
		      $this->warning(0x1,substr($tc,$pos_otag,30));
		      $known_tag = false;
		    }

		  } elseif (($pos_ctag = strpos($tc,$this->ctag,$tpos))!==false) {
		    // expression without double quotes + closing tag found

		    $expr = trim(substr($tc,$tpos,$pos_ctag-$tpos));

		  } else {
		    // closing tag not found
		    $this->warning(0x4,substr($tc,$pos_otag,30));
		    $known_tag = false;
		  }
		}

		// skip parsing unnecessary tags
		if( ($known_tag >= 50) && $skip_result ) {
			$tc = substr($tc,0,$pos_otag).substr($tc,$pos_ctag+strlen($this->ctag));
			continue;
		}

		switch( $known_tag ) {

		  // loop
		  case 1:
			$old_warn_mask = $this->disable_warnings;
			$this->disable_warnings |= 0x100;
			$loop_value = $this->parse_expr($expr,$param,$options);
			$this->disable_warnings = $old_warn_mask;

			if( is_array($loop_value) && (count($loop_value) > 0) ) {
				$sres = $skip_result;
			} else {
				$loop_value = array();
				$sres = true;
			}

			if( $sres ) {
				$value = array();
				$value['loop:iteration'] = 0;
				$value['loop:key'] = null;
				$value['loop:value'] = null;
				$value['loop:count'] = 0;
				foreach( $this->param as $gkey => $gvalue ) {
				  if( strncasecmp($gkey,'global:',7) != 0 )
					$value['global:'.$gkey] = $gvalue;
				}
				foreach( $param as $pkey => $pvalue )
					$value['parent:'.$pkey] = $pvalue;
				$tc = substr($tc,0,$pos_otag).
				      $this->parse_whole(
					substr($tc,$pos_ctag+strlen($this->ctag)),
					$value,
					array(
						'subtag_id' => 1,
						'skip_result' => true,
						'last_loop_iter' => true
					)
				      );
			} else {
			  $n = 0;
			  $s = substr($tc,0,$pos_otag);
			  foreach( $loop_value as $key => $value ) {
				$n++;
				if( !is_array($value) ) {
					$this->warning(0x200,substr($tc,$pos_otag,30),array($n,$key));
					$value = array();
				}

				$lvalue = $value;
				$value = array();
				foreach( $lvalue as $key2 => $value2 ) {
					$key2 = trim(strtolower($key2));
					if( (strncasecmp($key2,'loop:',5)==0) ||
					    (strncasecmp($key2,'global:',7)==0) ||
					    (strncasecmp($key2,'parent:',7)==0) ||
					    (strncasecmp($key2,'count:',6)==0) )
						continue;
					$value[$key2] = $value2;
					if( is_array($value2) )
						$value['count:'.$key2] = count($value2);
				}
				$value['loop:iteration'] = $n;
				$value['loop:key'] = $key;
				$value['loop:value'] = $value;
				$value['loop:count'] = count($loop_value);
				foreach( $param as $pkey => $pvalue ) {
				  if( strncasecmp($pkey,'global:',7) != 0 )
					$value['parent:'.$pkey] = $pvalue;
				}
				foreach( $this->param as $gkey => $gvalue ) {
				  if( strncasecmp($gkey,'global:',7) != 0 )
					$value['global:'.$gkey] = $gvalue;
				}
				$s .= $this->parse_whole(
					substr($tc,$pos_ctag+strlen($this->ctag)),
					$value,
					array(
						'subtag_id' => 1,
						'skip_result' => false,
						'last_loop_iter' => ($n == count($loop_value))
					)
				      );
			  }
			  $tc = $s;
			}
			break;

		  // endloop
		  case 2:
			if( $subtag_id != 1 ) {
			  $this->warning(0x8,substr($tc,$pos_otag,30),"ENDLOOP");
			  $spos = $pos_otag+1;
			  break;
			}

			if( $expr != '' ) {
			  $this->warning(0x10,substr($tc,$pos_otag,30),"ENDLOOP");
			}

			if( $skip_result ) {
			  return substr($tc,$pos_ctag+strlen($this->ctag));
			} else {
			  if( isset($options['last_loop_iter']) && $options['last_loop_iter']) {
				return substr($tc,0,$pos_otag).substr($tc,$pos_ctag+strlen($this->ctag));
			  } else {
				return substr($tc,0,$pos_otag);
			  }
			}

		  // if
		  case 3:
			$old_warn_mask = $this->disable_warnings;
			$this->disable_warnings |= 0x100;
			$ifres = (boolean)$this->parse_expr($expr,$param,$options);
			$this->disable_warnings = $old_warn_mask;

			$tc = substr($tc,0,$pos_otag).
			      $this->parse_whole(
				substr($tc,$pos_ctag+strlen($this->ctag)),
				$param,
				array(
					'subtag_id' => 3,
					'if_result' => $ifres,
					'skip_result' => $skip_result,
					'last_loop_iter' => isset($options['last_loop_iter']) ?
						$options['last_loop_iter'] : null
				)
			      );
			break;

		  // endif
		  case 4:
			// endif can be occur only after if, else or elseif
			if( ($subtag_id != 3) &&
			    ($subtag_id != 5) &&
			    ($subtag_id != 6) ) {
			  $this->warning(0x8,substr($tc,$pos_otag,30),"ENDIF");
			  $spos = $pos_otag+1;
			  break;
			}

			if( $expr != '' ) {
			  $this->warning(0x10,substr($tc,$pos_otag,30),"ENDIF");
			}

			if( $skip_result || !$if_result ) {
			  return substr($tc,$pos_ctag+strlen($this->ctag));
			} else {
			  return substr($tc,0,$pos_otag).substr($tc,$pos_ctag+strlen($this->ctag));
			}

		  // else
		  case 5:
			// else can be occur only after if or elseif
			if( ($subtag_id != 3) && ($subtag_id != 6) ) {
			  $this->warning(0x8,substr($tc,$pos_otag,30),"ELSE");
			  $spos = $pos_otag+1;
			  break;
			}

			if( $expr != '' ) {
			  $this->warning(0x10,substr($tc,$pos_otag,30),"ELSE");
			}

			if( $skip_result ) {
			  return $this->parse_whole(
					substr($tc,$pos_ctag+strlen($this->ctag)),
					$param,
					array(
						'subtag_id' => 5,
						'skip_result' => true
					)
				 );
			} else {
			  if( $if_result ) {
			    return substr($tc,0,$pos_otag).
				   $this->parse_whole(
					substr($tc,$pos_ctag+strlen($this->ctag)),
					$param,
					array(
						'subtag_id' => 5,
						'skip_result' => true
					)
				   );
			  } else {
			    return 
					$this->parse_whole(
					  substr($tc,$pos_ctag+strlen($this->ctag)),
					  $param,
					  array(
						'subtag_id' => 5,
						'skip_result' => false,
						'if_result' => true,
						'last_loop_iter' => isset($options['last_loop_iter']) ?
							$options['last_loop_iter'] : null
					  )
					);
			  }
			}
			break;

		  // elseif
		  case 6:
			// elseif can be occur only after if or elseif
			if( ($subtag_id != 3) && ($subtag_id != 6) ) {
			  $this->warning(0x8,substr($tc,$pos_otag,30),"ELSEIF");
			  $spos = $pos_otag+1;
			  break;
			}

			if( $skip_result ) {
			  return $this->parse_whole(
					  substr($tc,$pos_ctag+strlen($this->ctag)),
					  $param,
					  array(
						'subtag_id' => 6,
						'skip_result' => true
					  )
					);
			} else {
			  if( $if_result ) {
			    return substr($tc,0,$pos_otag).
				$this->parse_whole(
					 substr($tc,$pos_ctag+strlen($this->ctag)),
					 $param,
					 array(
						'subtag_id' => 6,
						'skip_result' => true
					 )
				       );
			  } else {
			     $options['subtag_id'] = 0;
			     $old_warn_mask = $this->disable_warnings;
			     $this->disable_warnings |= 0x100;
			     $ifres = (boolean)$this->parse_expr($expr,$param,$options);
			     $this->disable_warnings = $old_warn_mask;
			     return
			      $this->parse_whole(
				substr($tc,$pos_ctag+strlen($this->ctag)),
				$param,
				array(
					'subtag_id' => 6,
					'if_result' => $ifres,
					'skip_result' => false,
					'last_loop_iter' => isset($options['last_loop_iter']) ?
						$options['last_loop_iter'] : null
				)
			      );
			  }
			}
			break;

		  // ifset
		  case 7:
			if( trim($expr) == '' )
				$this->warning(0x20,substr($tc,$pos_otag,30),"IFSET");

			$tc = substr($tc,0,$pos_otag).
			      $this->parse_whole(
				substr($tc,$pos_ctag+strlen($this->ctag)),
				$param,
				array(
					'subtag_id' => 3,
					'if_result' => isset($param[$expr]),
					'skip_result' => $skip_result,
					'last_loop_iter' => isset($options['last_loop_iter']) ?
						$options['last_loop_iter'] : null
				)
			      );
			break;

		  // include
		  case 50:
			if( !isset($options['inc_num']) )
				$options['inc_num'] = 0;

			if( $options['inc_num'] >= $this->max_includes ) {
				$this->fatal("Maximum number of ".$this->max_includes.
				  " recursive inclusions reached near ".
				  htmlspecialchars('"'.substr($tc,$pos_otag,30).'..."'));
			}

			$file_name = $expr;

			$inc_dir = isset($options['inc_dir']) ? $options['inc_dir'] : $this->inc_dir;

			$file_contents = @file($inc_dir.$file_name);

			if( $file_contents === false ) {
				$this->fatal("Cannot read file \"".
				  htmlspecialchars($inc_dir.$file_name)."\" near ".
				  htmlspecialchars('"'.substr($tc,$pos_otag,30).'..."'));
			}

			$file_contents = implode('',$file_contents);

			$inc_dir = trim(dirname($inc_dir.$file_name));
			if( $inc_dir != '' )
				$inc_dir .= '/';

			$old_options = $options;
			$old_file_name = $this->file_name;
			$options['inc_num']++;
			$options['inc_dir'] = $inc_dir;
			$this->file_name = $inc_dir.$file_name;
			$res = $this->parse_whole($file_contents,$param,$options);
			$options = $old_options;
			$this->file_name = $old_file_name;
			$tc = substr($tc,0,$pos_otag).$res.substr($tc,$pos_ctag+strlen($this->ctag));
			$spos = $pos_otag+strlen($res);
			break;

		  // echo expression
		  case 51:
			$res = $this->parse_expr($expr,$param,$options);
			$tc = substr($tc,0,$pos_otag).$res.substr($tc,$pos_ctag+strlen($this->ctag));
			$spos = $pos_otag+@strlen($res);
			break;

		  // echo expression with encode html entities
		  case 52:
			$res = htmlspecialchars($this->parse_expr($expr,$param,$options));
			$tc = substr($tc,0,$pos_otag).$res.substr($tc,$pos_ctag+strlen($this->ctag));
			$spos = $pos_otag+@strlen($res);
			break;

		  // comment, just skip
		  case 53:
			$tc = substr($tc,0,$pos_otag).substr($tc,$pos_ctag+strlen($this->ctag));
			$spos = $pos_otag;
			break;

		  default:
			$spos = $pos_otag+1;
			break;
		}
	}

	if( (!isset($options['inc_num']) || ($options['inc_num'] == 0)) && 
            ($subtag_id == 1) ) {
	  $this->fatal("<b>ENDLOOP</b> tag not found");
	}

	if( (!isset($options['inc_num']) || ($options['inc_num'] == 0)) && 
            (($subtag_id == 3) || ($subtag_id == 5)) ) {
	  $this->fatal("<b>ENDIF</b> tag not found");
	}

	return $tc;

}

//--------------------------------------
// Parse template
// Input: none
// Output: parsed template as string
//--------------------------------------
function &parse() {
	$param = $this->param;
	$this->param = array();
	foreach( $param as $key => $value ) {
		$key = trim(strtolower($key));
		if( (strncasecmp($key,'loop:',5)==0) ||
		    (strncasecmp($key,'global:',7)==0) ||
		    (strncasecmp($key,'parent:',7)==0) ||
		    (strncasecmp($key,'count:',6)==0) )
			continue;
		$this->param[$key] = $value;
		if( is_array($value) )
			$this->param['count:'.$key] = count($value);
	}
	$gvals = $this->param;
	foreach( $gvals as $key => $value )
		$this->param['global:'.$key] = $value;
	return $this->parse_whole($this->template_contents);
}

}

class Template extends cTemplate {
	function parse() {
		global $session,$config,$self_plain_url,$self_host;

		$this->param("test","test");
		return parent::parse();
	}
}

?>
