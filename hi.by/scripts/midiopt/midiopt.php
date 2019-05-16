<?php

ini_set('error_reporting',E_ALL & ~E_NOTICE);

function fatal($msg) {
  echo "Fatal error: $msg\n";
  exit();
}

function rs2l($s) {
  return 16777216*ord($s[0])+(ord($s[3])|(ord($s[2])<<8)|(ord($s[1])<<16));
}

function rw2i($s) {
  return ord($s[1])|(ord($s[0])<<8);
}

function get_vl($str) {
  $val = 0;
  $len = 1;
  $i = 0;
  while( ($i < strlen($str)) && (ord($str[$i]) > 0x7f) ) {
    $val |= (ord($str[$i]) & 0x7f);
    $val = $val << 7;
    $len ++;
    $i++;
  }
  if( $i >= strlen($str) ) return false;
  $val |= ord($str[$i]);
  return array(0 => $val, 1 => $len);
}

function midi_optimize($sfc) {
  global $verbose;

  if( substr($sfc,0,4) != 'MThd' )
    return false;

  $hlen = rs2l(substr($sfc,4,4));
  if( $hlen != 6 )
    return false;

  $track_mode = rw2i(substr($sfc,8,2));
  $channels = rw2i(substr($sfc,10,2));

  if( $channels != 1 )
    return false;

  if( substr($sfc,14,4) != 'MTrk' )
    return false;

  $mid_len = rs2l(substr($sfc,18,4));
  $mid_data = substr($sfc,22,$mid_len);

  if( strlen($mid_data) != $mid_len )
    return false;

  $dfc = substr($sfc,0,18);

  $nmid = '';

  $event = false;
  while( $i < $mid_len ) {
    $cmd_ofs = $i;
    $skip_event = false;

    $res = get_vl(substr($mid_data,$i));
    if( $res === false ) return false;
    $i += $res[1];
    if( $i >= $mid_len ) return false;

    if( ord($mid_data[$i]) > 0x7f ) {
      $event = ord($mid_data[$i]);
      $i++;
    } else {
      if( $event === false ) return false;
    }

    if( $event == 0xFF ) {
      $i++; // $i now points to the event data length
      if( $i >= $mid_len ) return false;
      switch( ord($mid_data[$i-1]) ) {
        case 1:
        case 2:
        case 3:
        case 4:
        case 5:
        case 6:
        case 7:
          $skip_event = true;
	default:
	  break;
/*
        case 0:
        case 0x2F:
        case 0x51:
        case 0x58:
        case 0x59:
        case 0x7f:
          break;
*/
      }
      $res = get_vl(substr($mid_data,$i));
      if( $res === false ) return false;
      $i += $res[0] + $res[1];
      $event = false;
    } else {
      switch( $event & 0xF0 ) {
        case 0x80:
        case 0x90:
        case 0xA0:
        case 0xB0:
        case 0xE0:
          $i += 2;
          break;
        case 0xC0:
        case 0xD0:
          $i++;
          break;
        case 0xF0:
          $res = get_vl(substr($mid_data,$i));
          if( $res === false ) return false;
          $i += $res[0] + $res[1];
          $event = false;
          $skip_event = true;
          break;
      }
    }

    if( !$skip_event )
      $nmid .= substr($mid_data,$cmd_ofs,$i-$cmd_ofs);
  }

  $nmid_len = strlen($nmid);
  $dfc .= chr($nmid_len >> 24).chr(($nmid_len >> 16) & 0xFF).chr(($nmid_len >> 8) & 0xFF).chr($nmid_len & 0xFF);
  $dfc .= $nmid;

  return $dfc;
}

$files = array();
$extensions = array('.mid','.MID','.midi','.MIDI');

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

for( $i=0; $i<count($files); $i++ ) optimize_midi_from_file($files[$i]);

function optimize_midi_from_file($sfile) {

echo 'File: '.$sfile;
$dfile = $sfile;

$sfh = @fopen($sfile,"rb");
if( $sfh===false ) {
  echo " - error: Cannot open source file.\n";
  return;
}

$sfc = @fread ($sfh, filesize ($sfile));
fclose ($sfh);

if( strlen($sfc) != filesize($sfile) ) {
  echo " - error: Source file reading error.\n";
  return;
}

$dfc = midi_optimize($sfc);
if( $dfc === false ) {
  echo " - error: Invalid MIDI file.\n";
  return;
}

$dfh = @fopen($dfile,"wb");
if( $dfh===false ) {
  echo " - error: Cannot create destination file.\n";
  return;
}
fwrite($dfh,$dfc);
@fclose($dfh);


echo ' - ok (old size: '.strlen($sfc).' bytes, new: '.strlen($dfc)." bytes\n";
}

?>