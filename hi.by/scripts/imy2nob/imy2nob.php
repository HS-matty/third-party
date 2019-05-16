<?php

ini_set('error_reporting',E_ALL & ~E_NOTICE);

function fatal($msg) {
  echo "Fatal error: $msg\n";
  exit();
}

function add_bits(&$s,$bits,$len) {
  $slen = count($s['data']);
  $sbit = $s['sbit'];
  if( $sbit < 7 ) $slen--;

  $s['data'][$slen] &= (0xFF << ($sbit+1));

  if( $len > $sbit+1 ) {
    $s['data'][$slen] |= $bits >> ($len-$sbit-1);
    $len -= $sbit+1;
    $sbit = 7;
    $slen++;
  }

  if( $len > 0 ) {
    $s['data'][$slen] |= ($bits << (1+$sbit-$len)) & 0xFF;
    $sbit -= $len;
    if( $sbit < 0 ) $sbit = 7;
  }
  $s['sbit'] = $sbit;
}

function imy2nob($sfc,$name) {
  global $skip_volume;

if( strlen($name) > 15 ) {
  fatal("Melody name can be up to 15 characters long");
}

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

if( strlen($imelody['name']) > 15 ) {
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

$valid_beat = array(25,28,31,35,40,45,50,56,63,70,80,90,100,
                    112,125,140,160,180,200,225,250,285,320,355,400,
                    450,500,565,635,715,800,900);

//***************
//  Set BPM
//***************
if( !isset($imelody['beat']) ) {
  $imelody['beat'] = 120;
}

$beat = (int)(0 + $imelody['beat']);
if( ($beat < 25) || ($beat > 900) ) {
  fatal("Invalid BEAT value: ".$beat);
}

$beat_ind = array_search($beat,$valid_beat);
if( $beat_ind === false ) {
  for( $i=1; $i<count($valid_beat); $i++ ) {
    if( $beat < $valid_beat[$i] ) {
      $beat_ind = $i;
      break;
    }
  }
  if( ($beat - $valid_beat[$beat_ind-1]) < ($valid_beat[$beat_ind]-$beat) ) {
    $beat_ind--;
  }
  echo "(Beat=".$valid_beat[$beat_ind]." instead of ".$beat.") ";
}
$beat = $beat_ind;

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
$nind = 0;
$note = array();

if( $beat != 8 ) {
  $note[$nind]['beat'] = $beat;
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

$nob_octave = 4;

//***************
//  Parse melody
//***************
while( $i < $ml ) {

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

  $octave = 4;

  // Check for octave prefix
  if( $mel[$i] == '*' ) {
    $c = $mel[$i+1];
    if( ($c >= '0') && ($c <= '8') ) {
      $octave = ord($c) - 48;
      $i+=2;
    } else {
      fatal("Invalid melody data near '".substr($mel,$i)."'");
    }
    if( ($octave < 3) || ($octave > 6) ) {
      fatal("Octave out of range near '".substr($mel,$i-2)."'");
    }
  }

  // Check for note
  $note_index = array_search($mel[$i],$plain_notes);
  if( $note_index !== false ) {
    $note[$nind]['note'] = $plain_note_value[$note_index];
    $i++;
  } else {
    $note_index = array_search(substr($mel,$i,2),$ess_notes);
    if( $note_index !== false ) {
      $note[$nind]['note'] = $ess_iss_note_value[$note_index];
      $i+=2;
    } else {
      $note_index = array_search(substr($mel,$i,2),$iss_notes);
      if( $note_index !== false ) {
        $note[$nind]['note'] = $ess_iss_note_value[$note_index];
        $i+=2;
      }
    }
  }

  if( $note_index !== false ) {

    if( $octave != $nob_octave ) {
      $ncopy = $note[$nind];
      unset($note[$nind]);
      $note[$nind]['octave'] = $octave;
      $nind++;
      $note[$nind] = $ncopy;
      $nob_octave = $octave;
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
    $note[$nind]['note'] = 0;
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

if( count($note) > 255 ) {
  fatal("Melody too long (more than 255 instructions)");
}

if( count($note) > 80 ) {
  echo "(more than 80 events (".count($note).") - not all Nokia phones will able to play it)";
}

//***************
//  Create Nokring file
//***************

$nob = array( 'data' => array(), 'sbit' => 7 );

add_bits($nob,2,8);
add_bits($nob,0x4A,8);

add_bits($nob,0x1D,7);
add_bits($nob,1,3);

add_bits($nob,strlen($name),4);
for( $i=0; $i<strlen($name); $i++ )
  add_bits($nob,ord($name[$i]),8);
add_bits($nob,1,8); // 1 song patterns
add_bits($nob,0,3); // pattern-header
add_bits($nob,0,2); // A-part
add_bits($nob,0,4); // no loop

add_bits($nob,count($note),8); // pattern length - number of instructions
for( $i=0; $i<count($note); $i++ ) {
  if( isset($note[$i]['note']) ) {
    add_bits($nob,1,3);
    add_bits($nob,$note[$i]['note'],4);
    add_bits($nob,$note[$i]['duration'],3);
    add_bits($nob,$note[$i]['durspec'],2);
    continue;
  }
  if( isset($note[$i]['octave']) ) {
    add_bits($nob,2,3);
    add_bits($nob,$note[$i]['octave']-3,2);
    continue;
  }
  if( isset($note[$i]['style']) ) {
    add_bits($nob,3,3);
    add_bits($nob,$note[$i]['style'],2);
    continue;
  }
  if( isset($note[$i]['beat']) ) {
    add_bits($nob,4,3);
    add_bits($nob,$note[$i]['beat'],5);
    continue;
  }
  if( isset($note[$i]['volume']) ) {
    add_bits($nob,5,3);
    add_bits($nob,$note[$i]['volume'],4);
    continue;
  }
  fatal("Internal error");
}

$nob['sbit'] = 7;
add_bits($nob,0,8);

if( count($nob['data']) > 384 ) {
  fatal("Warning: melody will not fits in 3 SMS messages");
}

$nob_str = '';
for( $i=0; $i<count($nob['data']); $i++ ) {
  $nob_str .= chr($nob['data'][$i]);
}

return $nob_str;
}

// ignore volume change
$skip_volume = true;

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

for( $i=0; $i<count($files); $i++ ) imy2nob_from_file($files[$i]);

function imy2nob_from_file($sfile) {

echo $sfile.' - ';
$dfile_name = basename($sfile);
$dot_index = strrpos($dfile_name,'.');
if( $dot_index !== false ) {
  $dfile_name = substr($dfile_name,0,$dot_index);
}

$sfh = @fopen($sfile,"rb");
if( $sfh===false ) {
  fatal("Cannot open source file.");
}

$sfc = @fread ($sfh, filesize ($sfile));
fclose ($sfh);

if( strlen($sfc) != filesize($sfile) ) {
  fatal("Source file reading error.");
}

$nob_str = imy2nob($sfc,'1'.$dfile_name);

$dfh = @fopen($dfile_name.'.nob',"wb");
if( $dfh===false ) {
  fatal("Cannot create destination file.");
}
fwrite($dfh,$nob_str);
@fclose($dfh);

echo "done\n";
}

?>