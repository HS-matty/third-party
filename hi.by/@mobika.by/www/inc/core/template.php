<?php

class coreTemplate {

	var $template_contents;
	var $param;
	var $max_includes = 10;
	var $inc_dir;
	var $tags = array(
			0 => 'loop ',
			1 => 'endloop',
			2 => 'if ',
			3 => 'endif',
			4 => 'else',
			5 => 'elseif ',
			49 => 'include ',
			50 => 'echo ',
			51 => 'echohtml ',
			52 => 'loop_iteration',
			53 => 'loop_key'
		    );
	var $otag ='<%';
	var $ctag ='>';

	// Warnings:
	//  1 - Invalid expression definition: closing double quote not found
	//  2 - Unknown tag
	//  4 - Tag not closed
	//  8 - Unexpected tag (e.g. ENDIF without preceding IF)
	//  16 - UExpressions not allowed (e.g. in ELSE tag)

	var $disable_warnings;
	var $enable_eval_errors;

function fatal($msg) {
	print "<b>[Template] Error:</b> ".$msg;
	exit;
}

function warning($wmask,$code,$val='') {

	if( !($this->disable_warnings & $wmask) ) {
		$code = htmlspecialchars($code);
		$val = htmlspecialchars($val);
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

		  // expression warnings

		  case 0x100:
			$msg = "Undefined modifier <b>".$val."</b> in expression near \"".$code."...\" - ignored<br>\n";
			break;

		  case 0x200:
			$msg = "Undefined parameter <b>".$val."</b> in expression near \"".$code."...\" - assuming NULL<br>\n";
			break;

		  case 0x400:
			$msg = "Undefined global parameter <b>".$val."</b> in expression near \"".$code."...\" - assuming NULL<br>\n";
			break;

		  // unknown warning

		  default:
			$msg = "Unknown warning near \"".$code."...\"";
			break;
		}
		print "<b>[Template] Warning:</b> ".$msg;
	}
}

function cTemplate($filename,$options=array()) {
	$param = array();
	$fh = @fopen($filename,"rb");
	if( !$fh ) $this->fatal("Failed opening file '".$filename."'",1);
	$this->template_contents = fread ($fh, filesize ($filename));
	@fclose ($fh);
	$this->inc_dir = dirname($filename).'/';
	if( isset($options['disable_warnings']) ) {
		$this->disable_warnings = $options['disable_warnings'];
	} else {
		$this->disable_warnings = 2 | 0x10 | 0x200 | 0x400;
	}
	if( isset($options['enable_eval_errors']) &&
            $options['enable_eval_errors'] ) {
		$this->enable_eval_errors = true;
	} else {
		$this->enable_eval_errors = false;
	}
}

function param($key,$val) {
	$this->param[$key] = $val;
	return true;
}

/*

Expressions syntax:

varname - get var from current scope;
global:varname - get var from global parameters;

Rest of the string must be valid PHP expression without ' and ".

*/


function parse_expr($e,$param) {

	$expr = $e;

	$pos = 0;
	while( $pos<strlen($e) ) {

	  if( (($e[$pos] >= 'a') && ($e[$pos] <= 'z')) ||
	      (($e[$pos] >= 'A') && ($e[$pos] <= 'Z')) ) {

		$pos2 = $pos+1;
		$s = $e[$pos];
		$modifier = '';

		while( $pos2<strlen($e) ) {
			if( (($e[$pos2] >= 'a') && ($e[$pos2] <= 'z')) ||
			    (($e[$pos2] >= 'A') && ($e[$pos2] <= 'Z')) ||
			    (($e[$pos2] >= '0') && ($e[$pos2] <= '9')) ||
			    ($e[$pos2] == '_') ) {
				$s .= $e[$pos2];
				$pos2++;
				continue;
			}

			if( ($e[$pos2] == ':') &&
			    (strlen($modifier) == 0) &&
			    (strlen($s) > 0) ) {
				$modifier = $s;
				$s = '';
				$pos2++;
				continue;
			}

			break;
		}

		$var = '';

		if( strcasecmp($modifier,'global')==0 ) {
		  if( !isset($this->param[$s]) ) {
		    $this->warning(0x400,substr($e,0,30),$s);
		    $var = "NULL";
		  } else {
		    $var = '$this->param[\'' .$s."']";
		  }
		} else {
		  if( $modifier!='' ) {
			$this->warning(0x100,substr($e,$pos,30),$modifier);
		  }

		  if( !isset($param[$s]) ) {
		    $this->warning(0x200,substr($e,$pos,30),$s);
		    $var = "NULL";
		  } else {
		    $var = '$param[\''.$s."']";
		  }
		}

		$e = substr($e,0,$pos).$var.substr($e,$pos2);
		$pos += strlen($var);
		continue;
	  }

	  if( (strlen($e) > $pos+2) && in_array(
		substr($e,$pos,3),
		array("===","!==")
		) ) {
		$pos += 3;
		continue;
	  }

	  if( (strlen($e) > $pos+1) && in_array(
		substr($e,$pos,2),
		array("||","&&","==","!=","<=",">=","<<",">>","++","--")
		) ) {
		$pos += 2;
		continue;
	  }

	  if( strpos(chr(9).' 0123456789()|^&<>+-.*%!/~',$e[$pos])===false ) {
		$this->fatal('Expression <b>'.htmlspecialchars($expr).'</b> error near "'.
			htmlspecialchars(substr($e,$pos,30))."...\"<br>\n");
	  }

	  $pos++;
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

function parse_whole($tc,$param=false,$options=array()) {

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

		// skip parsing any data after loop tag but before endloop
		// this will be done in endloop parser section
		if( ($subtag_id == 1) && ($known_tag != 2) ) {
			$known_tag = false;
		}

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
			$loop_value = $this->parse_expr($expr,$param);
			if( is_array($loop_value) ) {
				$sres = $skip_result;
			} else {
				$loop_value = array();
				$sres = true;
			}

			$tc = substr($tc,0,$pos_otag).
			      $this->parse_whole(
				substr($tc,$pos_ctag+strlen($this->ctag)),
				$loop_value,
				array(
					'subtag_id' => 1,
					'skip_result' => $sres
				)
			      );
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
			  $s = '';
			  if( is_array($param) ) {
			    $i = 1;
			    foreach( $param as $key => $value ) {
			      $s .= $this->parse_whole(
					substr($tc,0,$pos_otag),
					$value,
					array(
						'loop_iteration' => $i,
						'loop_key' => $key
					)
				    );
			      $i++;
			    }
			  }
			  return $s.substr($tc,$pos_ctag+strlen($this->ctag));
			}

		  // if
		  case 3:
			$tc = substr($tc,0,$pos_otag).
			      $this->parse_whole(
				substr($tc,$pos_ctag+strlen($this->ctag)),
				$param,
				array(
					'subtag_id' => 3,
					'if_result' => (boolean)$this->parse_expr($expr,$param),
					'skip_result' => $skip_result
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
						'if_result' => true
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
			     return 
			      $this->parse_whole(
				substr($tc,$pos_ctag+strlen($this->ctag)),
				$param,
				array(
					'subtag_id' => 6,
					'if_result' => (boolean)$this->parse_expr($expr,$param),
					'skip_result' => false
				)
			      );
			  }
			}
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
			$options['inc_num']++;
			$options['inc_dir'] = $inc_dir;
			$res = $this->parse_whole($file_contents,$param,$options);
			$options = $old_options;

			$tc = substr($tc,0,$pos_otag).$res.substr($tc,$pos_ctag+strlen($this->ctag));
			$spos = $pos_otag+strlen($res);
			break;

		  // echo expression
		  case 51:
			$res = $this->parse_expr($expr,$param);
			$tc = substr($tc,0,$pos_otag).$res.substr($tc,$pos_ctag+strlen($this->ctag));
			$spos = $pos_otag+strlen($res);
			break;

		  // echo expression with encode html entities
		  case 52:
			$res = htmlspecialchars($this->parse_expr($expr,$param));
			$tc = substr($tc,0,$pos_otag).$res.substr($tc,$pos_ctag+strlen($this->ctag));
			$spos = $pos_otag+strlen($res);
			break;

		  // echo loop iteration number
		  case 53:
			if( $expr != '' ) {
			  $this->warning(0x10,substr($tc,$pos_otag,30),"LOOP_ITERATION");
			}

			if( isset($options['loop_iteration']) ) {
				$tc = substr($tc,0,$pos_otag).$options['loop_iteration'].substr($tc,$pos_ctag+strlen($this->ctag));
				$spos = $pos_otag+strlen($options['loop_iteration']);
			} else {
				$this->warning(0x8,substr($tc,$pos_otag,30),"LOOP_ITERATION");
				$spos = $pos_otag+1;
			}
			break;

		  // echo loop iteration key
		  case 54:
			if( $expr != '' ) {
			  $this->warning(0x10,substr($tc,$pos_otag,30),"LOOP_KEY");
			}

			if( isset($options['loop_key']) ) {
				$tc = substr($tc,0,$pos_otag).$options['loop_key'].substr($tc,$pos_ctag+strlen($this->ctag));
				$spos = $pos_otag+strlen($options['loop_key']);
			} else {
				$this->warning(0x8,substr($tc,$pos_otag,30),"LOOP_KEY");
				$spos = $pos_otag+1;
			}
			break;

		  default:
			$spos = $pos_otag+1;
			break;
		}
	}

	if( $subtag_id == 1 ) {
	  $this->fatal("<b>ENDLOOP</b> tag not found");
	}

	if( ($subtag_id == 3) || ($subtag_id == 5) ) {
	  $this->fatal("<b>ENDIF</b> tag not found");
	}

	return $tc;

}

//--------------------------------------
// Parse template
// Input: file contents as string
// Output: parsed template as string
//--------------------------------------
function parse() {
	return $this->parse_whole($this->template_contents);
}

}

?>