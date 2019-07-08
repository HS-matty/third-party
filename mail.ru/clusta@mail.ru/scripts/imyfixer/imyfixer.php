<?php

$shift_octaves = false;

ini_set('error_reporting',E_ALL & ~E_NOTICE);

// ignore volume change
$skip_volume = true;

function fatal($msg) {
  echo "Fatal error: $msg\n";
  exit();
}

function imy_fixer($sfc,$shift_octaves=false) {
  global $skip_volume;

$fstr = array();
$nl_pos = 0;
while( true ) {
  $nl_pos_old = $nl_pos;
  $nl_pos = strpos($sfc,chr(0x0D).chr(0x0A),$nl_pos_old);
  if( $nl_pos === false )
    break;
  $fstr[] = substr($sfc,$nl_pos_old,$nl_pos-$nl_pos_old);
  $nl_pos += 2;
}

if( ($nl_pos_old != strlen($sfc)) ||
    (count($fstr) < 5) ||
    ($fstr[0] != 'BEGIN:IMELODY') ||
    (($fstr[1] != 'VERSION:1.0') && ($fstr[1] != 'VERSION:1.2')) ||
    ($fstr[2] != 'FORMAT:CLASS1.0') ||
    ($fstr[count($fstr)-1] != 'END:IMELODY') ) {
  fatal("Invalid iMelody file.");
}

$imelody = array();
$itags = array(
  'NAME:' => 'name',
  'COMPOSER:' => 'composer',
  'BEAT:' => 'beat',
  'STYLE:' => 'style',
  'VOLUME:' => 'volume',
  'COPYRIGHT:' => 'copyright',
  'MELODY:' => 'melody'
);

//***************
//  Read iMelody tags
//***************
for( $i=3; $i<count($fstr)-1; $i++ ) {
  $tag_found = false;
  foreach( $itags as $key => $value ) {
    if( substr($fstr[$i],0,strlen($key)) == $key ) {
      $tag_found = true;
      $imelody[$value] = substr($fstr[$i],strlen($key));
      break;
    }
  }
  if( !$tag_found ) {
    fatal("Invalid data found near '".$fstr[$i]."'");
  }
}

$ml = strlen($imelody['melody']);
if( $ml == 0 ) {
  fatal("No melody data found");
}

if( @strlen($imelody['name']) > 15 ) {
  fatal("iMelody name can be up to 15 characters long");
}

//***************
//  Set style
//***************
$style = 0;
if( isset($imelody['style']) ) {
  if( (($imelody['style'][0] != 'S') && ($imelody['style'][0] != 's')) || 
      !(($imelody['style'][1] >= '0') && ($imelody['style'][1] <= '2')) ) {
    fatal("Invalid style specifier: ".$imelody['style']);
  }
  $style = ord($imelody['style'][1]) - 48;
}

if( $style != 0 ) {
  echo "Warning:\n  non-natural style used: style can be ignored by some devices\n";
}

//***************
//  Set volume
//***************
$volume = 7;
$volume_after_note = $volume;
if( isset($imelody['volume']) ) {
  $volume = 0+substr($imelody['volume'],1);
  if( ($imelody['volume'][0] != 'V') || 
      !(($volume >= 0) && ($volume <= 15)) ) {
    fatal("Invalid volume specifier: ".$imelody['volume']);
  }
}

//***************
//  Initialize structures
//***************
$i=0;
$mel = &$imelody['melody'];
$new_mel = '';
$nind = 0;
$note = array();

if( isset($imelody['beat']) ) {
  $note[$nind]['beat'] = $imelody['beat'];
  $nind++;
}

if( $style != 0 ) {
  $note[$nind]['style'] = $style;
  $nind++;
}

$plain_notes = array('c','d','e','f','g','a','b');
$ess_notes = array('&d','&e','&g','&a','&b');
$iss_notes = array('#c','#d','#f','#g','#a');
$plain_note_value = array(1,3,5,6,8,0x0A,0x0C);
$ess_iss_note_value = array(2,4,7,9,0x0B);

//$octave = 10;

$note_parsed = false;

//***************
//  Parse melody
//***************
while( $i < $ml ) {

  // Check for octave prefix
  if( $mel[$i] == '*' ) {
    $c = $mel[$i+1];
    if( ($c >= '0') && ($c <= '8') ) {
      $imel_octave = ord($c) - 48;
//      if( $octave != $imel_octave ) {
        $octave = $imel_octave;
        $note[$nind]['octave'] = $octave;
//      }
      $i+=2;
      continue;
    } else {
      fatal("Invalid melody data near '".substr($mel,$i)."'");
    }
  }

  // Check for volume prefix
  if( substr($mel,$i,2) == 'V+' ) {
    if( $volume < 15 ) $volume++;
    $i+=2;
    continue;
  }

  if( substr($mel,$i,2) == 'V-' ) {
    if( $volume > 0 ) $volume--;
    $i+=2;
    continue;
  }

  if( $mel[$i] == 'V' ) {
    if( ($mel[$i+1] >= '0') && ($mel[$i+1] <= '9') ) {
      if( $mel[$i+1] != '1' ) {
        $volume = ord($mel[$i+1])-48;
        $i+=2;
        continue;
      } else {
        if( ($mel[$i+2] >= '0') && ($mel[$i+2] <= '5') ) {
          $volume = 10 + ord($mel[$i+2]) - 48;
          $i+=3;
          continue;
        } else {
          $volume = 1;
          $i+=2;
          continue;
        }
      }
    } else {
      fatal("Invalid volume specifier near '".substr($mel,$i)."'");
    }
  }

  // Check for note
  $note_index = array_search($mel[$i],$plain_notes);
  if( $note_index !== false ) {
//    $note[$nind]['note'] = $plain_note_value[$note_index];
    $note[$nind]['note'] = $plain_notes[$note_index];
    $i++;
  } else {
    $note_index = array_search(substr($mel,$i,2),$ess_notes);
    if( $note_index !== false ) {
//      $note[$nind]['note'] = $ess_iss_note_value[$note_index];
      $note[$nind]['note'] = $ess_notes[$note_index];
      $i+=2;
    } else {
      $note_index = array_search(substr($mel,$i,2),$iss_notes);
      if( $note_index !== false ) {
//        $note[$nind]['note'] = $ess_iss_note_value[$note_index];
        $note[$nind]['note'] = $iss_notes[$note_index];
        $i+=2;
      }
    }
  }

  if( $note_index !== false ) {
    // Note found - check for octave defined
    if( !isset($note[$nind]['octave']) ) {
      $note[$nind]['octave'] = 4;
    }

    // Note found - check for volume change
    if( !$skip_volume && ($volume != $volume_after_note) ) {
      $ncopy = $note[$nind];
      unset($note[$nind]);
      $note[$nind]['volume'] = $volume;
      $nind++;
      $note[$nind] = $ncopy;
      $volume_after_note = $volume;
    }

    // Note found - check for duration
    if( ($mel[$i] >= '0') && ($mel[$i] <= '5') ) {
      $note[$nind]['duration'] = ord($mel[$i]) - 48;
      $note[$nind]['durspec'] = 0;
      $i++;

      // Check for duration specifier
      if( $mel[$i] == '.' ) {
        $note[$nind]['durspec'] = 1;
        $i++;
      } elseif( $mel[$i] == ':' ) {
        $note[$nind]['durspec'] = 2;
        $i++;
      } elseif( $mel[$i] == ';' ) {
        $note[$nind]['durspec'] = 3;
        $i++;
      }

    } else {
      fatal("Invalid duration found near '".substr($mel,$i-2)."'");
    }

    $nind++;
    continue;
  }

  // Check for rest
  if( $mel[$i] == 'r' ) {
//    $note[$nind]['note'] = 0;
    $note[$nind]['note'] = 'r';
    $i++;

    // Rest found - check for duration
    if( ($mel[$i] >= '0') && ($mel[$i] <= '5') ) {
      $note[$nind]['duration'] = ord($mel[$i]) - 48;
        $note[$nind]['durspec'] = 0;
      $i++;

      // Check for duration specifier
      if( $mel[$i] == '.' ) {
        $note[$nind]['durspec'] = 1;
        $i++;
      } elseif( $mel[$i] == ':' ) {
        $note[$nind]['durspec'] = 2;
        $i++;
      } elseif( $mel[$i] == ';' ) {
        $note[$nind]['durspec'] = 3;
        $i++;
      }

    } else {
      fatal("Invalid duration found near '".substr($mel,$i-2)."'");
    }

    $nind++;
    continue;
  }

  fatal("Unknown data found near '".substr($mel,$i)."'");
}

//***************
//  Check for octaves and shift if necessary
//***************

$min_octave = 10;
$max_octave = -1;
for( $i=0; $i<count($note); $i++ ) {
  if( isset($note[$i]['octave']) ) {
    if( ($note[$i]['note'] != 'r') && ($note[$i]['octave'] > $max_octave) ) {
      $max_octave = $note[$i]['octave'];
    }
    if( ($note[$i]['note'] != 'r') && ($note[$i]['octave'] < $min_octave) ) {
      $min_octave = $note[$i]['octave'];
    }
  }
}

$shift_octave = 0;
if( $min_octave != 10 ) {
  if( $max_octave - $min_octave > 3 ) {
    fatal("Melody uses more than 4 octaves");
  } elseif( $max_octave - $min_octave == 3 ) {
    // 4 octaves in use
//    echo "Warning:\n  4 octaves used: iMelody can be played incorrectly on some devices\n";
    echo "(4 octaves) ";
    $shift_octave = 3-$min_octave;
  } elseif( $max_octave - $min_octave == 2 ) {
    // 3 octaves in use
    if( $shift_octaves ) {
      $shift_octave = 4-$min_octave;
    } else {
      if( $min_octave >= 4 ) {
        $shift_octave = 4-$min_octave;
      } else {
        $shift_octave = 3-$min_octave;
      }
    }
  } elseif( $max_octave - $min_octave == 1 ) {
    // 2 octaves in use
    if( $shift_octaves ) {
      $shift_octave = 4-$min_octave;
    } else {
      if( $min_octave >= 5 ) {
        $shift_octave = 5-$min_octave;
      } elseif( $min_octave <= 3 ) {
        $shift_octave = 3-$min_octave;
      } else {
        $shift_octave = 0;
      }
    }
  } else {
    // 1 octave in use
    if( $shift_octaves ) {
      $shift_octave = 4-$min_octave;
    } else {
      if( $min_octave <= 3 ) {
        $shift_octave = 3-$min_octave;
      } elseif( $min_octave >= 6 ) {
        $shift_octave = 6-$min_octave;
      } else {
        $shift_octave = 0;
      }
    }
  }
}

if( $shift_octave != 0 ) {
  for( $i=0; $i<count($note); $i++ ) {
    if( isset($note[$i]['octave']) ) {
      $note[$i]['octave'] += $shift_octave;
    }
  }
}

//***************
//  Check for durations
//***************
$warn_dur = false;
$warn_durspec = false;
for( $i=0; $i<count($note); $i++ ) {
  if( isset($note[$i]['duration']) && ($note[$i]['duration'] > 3) ) {
    $warn_dur = true;
  }
  if( isset($note[$i]['durspec']) && ($note[$i]['durspec'] != 0) ) {
    $warn_durspec = true;
  }
}

if( $warn_dur ) {
//  echo "Warning:\n  1/16 and/or 1/32 durations are used:\n  iMelody can be played incorrectly on some devices\n";
  echo "(1/16, 1/32) ";
}

if( $warn_durspec ) {
  echo "(,:;) ";
}

/*
if( count($note) > 255 ) {
  fatal("Melody too long (more than 255 instructions)");
}

if( count($note) > 80 ) {
  fatal("Warning:\n  melody consist of > 80 events: not all Nokia phones will able to play it");
}
*/

//***************
//  Create new iMelody file
//***************

$new_mel = $imelody;
$new_mel['melody'] = '';
$octave = 4;
for( $i=0; $i<count($note); $i++ ) {
  if( isset($note[$i]['beat']) ) {
    continue;
  }
  if( isset($note[$i]['octave']) ) {
    $octave = $note[$i]['octave'];
  }
  if( isset($note[$i]['note']) ) {
    $new_mel['melody'] .=
      ((($octave != 4) && ($note[$i]['note'] != 'r')) ? '*'.$octave : '').
      $note[$i]['note'].
      $note[$i]['duration'].
      ($note[$i]['durspec'] > 0 ? (
        $note[$i]['durspec'] == 1 ? '.' : (
          $note[$i]['durspec'] == 2 ? ':' : (
            $note[$i]['durspec'] == 3 ? ';' : ''
          )
        )
      ) : '');
  }
}

$new_mel_str = 'BEGIN:IMELODY
VERSION:1.0
FORMAT:CLASS1.0
';
if( isset($new_mel['beat']) && (abs($new_mel['beat'] - 120) > 15) ) {
  $new_mel_str .= 'BEAT:'.$new_mel['beat']."\x0D\x0A";
}
$new_mel_str .= 'MELODY:'.$new_mel['melody']."\x0D\x0A".'END:IMELODY'."\x0D\x0A";

return $new_mel_str;
}

$files = array();
$extensions = array('.imy','.IMY');

if ($handle = opendir(getcwd())) {
    while (false !== ($sfile = readdir($handle))) { 
        if ($sfile != "." && $sfile != ".." &&
           array_search(substr($sfile,-4),$extensions) !== false ) {
		$files[] = $sfile;
        }
    }
    closedir($handle); 
} else {
  fatal("Cannot read directory");
}

for( $i=0; $i<count($files); $i++ ) fix_from_file($files[$i],$shift_octaves);

function fix_from_file($sfile,$shift_octaves=false) {

echo $sfile.' - ';
$dfile_name = basename($sfile,'.imy');

$sfh = @fopen($sfile,"rb");
if( $sfh===false ) {
  fatal("Cannot open source file.");
}

$sfc = @fread ($sfh, filesize ($sfile));
fclose ($sfh);

if( strlen($sfc) != filesize($sfile) ) {
  fatal("Source file reading error.");
}

$new_mel_str = imy_fixer($sfc,$shift_octaves);
if( strlen($new_mel_str) > 128 ) {
  echo ">128, shifting... ";
  $new_mel_str = imy_fixer($sfc,true);
}

if( strlen($new_mel_str) <= 128 ) {
  @mkdir('128');
  $dfh = @fopen('128/'.$dfile_name.'.imy',"wb");
  echo "Writing 128/".$dfile_name.'.imy ...';
  if( $dfh===false ) {
    fatal("Cannot create destination file.");
  }
  fwrite($dfh,$new_mel_str);
  @fclose($dfh);
} else {
  @mkdir('long');
  echo "iMelody more than 128 bytes long. ";
  echo "Writing long/".$dfile_name.'.imy ...';
  $dfh = @fopen('long/'.$dfile_name.'.imy',"wb");
  if( $dfh===false ) {
    fatal("Cannot create destination file.");
  }
  fwrite($dfh,$new_mel_str);
  @fclose($dfh);
}

/*
$dfh = @fopen($dfile_name.'.iml',"wb");
if( $dfh===false ) {
  fatal("Cannot create destination file.");
}
fwrite($dfh,$new_mel_str);
@fclose($dfh);
*/

echo "done\n";
}

?>