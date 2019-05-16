<script language="php">
/* =============================================================
 *	News Headlines Database update script v1.1
 *	(C)opyright 2000 HMage, Minsk, Belarus.
 * =============================================================
 *
 *	This first part of the script blocks unauthorized
 * 	access to the script.
 * 	(the script itself takes much resources from server)
 */

error_reporting (341);
require_once ("cgi-bin/news.inc");

// Abstraction layer for echo.
function echof ($string) {
	global $allowoutput;
	if ($allowoutput) echo $string;
}

// In real 'C' language I would make it a #define.
function put_forbidden () {
	global $note;
	header ("HTTP/1.0 403 Forbidden");
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	echof ($note["ERROR403"]);
}

// Check if the the news add file is valid for processing.
function valid_newsaddname ($dirfile) {
	global $verbose;
	global $file;

	if (!file_exists ($file["adddir"] . $dirfile)) {
		echof ("file $dirfile does not exist<br>\n");
		return 0;
	}
	if (!is_readable ($file["adddir"] . $dirfile)) {
		echof ("file $dirfile cannot be read<br>\n");
		return 0;
	}
	if (!is_writable ($file["adddir"] . $dirfile)) {
		if ($verbose) echof ("file $dirfile cannot be written<br>\n");
	}
	return 1;
}

ob_start();


$allowoutput = 1;
$verbose = 1;
$stringvariable = "do";
$stringallow = "thisisathing";
$stringallowverbose = "thisisarealthing";

if (empty ($calledfromphp)) {
	if (isset ($HTTP_GET_VARS[$stringvariable])) {
		$stringvalue = $HTTP_GET_VARS[$stringvariable];
		if ($stringvalue == $stringallow) {
			$verbose = 0;
		} else if ($stringvalue == $stringallowverbose) {
			$verbose = 1;
		} else {
			put_forbidden();
			return;
		}
		unset ($stringvalue);

		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
	} else {
		put_forbidden();
		return;
	}
} else {
	$verbose = 0;
	$allowoutput = 0;
}

</script><script language="php">
/*
 * This part of the script fills
 * the $bases[] filename array and sorts
 * in descending order
 * (newest archive file first).
 */

if ($verbose) echof ("<small>" . microtime() . "</small><br>\n");
echof ("Updating news database...");

if ($verbose) echof ("<hr>\n");
if ($verbose) echof ("Looking for news base files...<br>\n");

$touchfiletime = filemtime ($file["touchfile"]);
$time_now = time();
$needupdate = 0;

unset ($bases);
$numbasefiles = getbasefiles ($bases);

if ($numbasefiles) {
	for ($i = 0; $i < $numbasefiles; $i++) {
		$bases[$i] = $file["basedir"] . $bases[$i];
		if ($verbose) echof ("Found base file '<strong>" . basename($bases[$i]) . "</strong>'");
		if (filemtime ($bases[$i]) > $touchfiletime) {
			$needupdate = 1;
			if ($verbose) echof (", that needs to be rebuilt.");
		}
		if ($verbose) echof ("<br>\n");
	}
} else {
	if ($verbose) echof ("Found no files<br>\n");
}


if ($verbose) echof ("<br>\n");

</script><script language="php">
/*
 *	This part of the script detects whether
 *	base update is necessary to be done.
 */
reset ($sections);
while (list ($section, $sarray) = each ($sections)) {
	if (filemtime ($file['basedir'] . $section . $extension['cacheext']) < $touchfiletime) {
		$needupdate = 1;
		break;
	}
}

</script><script language="php">
/*
 *	This part of the script fills
 * 	the $addfiles[] array and sorts in descending order
 * 	(newest file first).
 */

if ($verbose) echof ("<hr>\n");
if ($verbose) echof ("Looking for addfiles...<br>\n");

$numaddfiles = 0;

$dirhandle = opendir($file["adddir"]);
while (is_string($dirfile = readdir($dirhandle))) {

	if (($dirfile != ".") && ($dirfile != "..")) {
		$temp1 = $extension["addext"];
		$temp2 = substr ($dirfile, strrpos ($dirfile, '.'));

		if (!strcasecmp ($temp1, $temp2)) {
			if (valid_newsaddname ($dirfile)) {
				$addfiles[] = $dirfile;
				$numaddfiles++;
			}
		}
	}
}

closedir($dirhandle);

if ($numaddfiles) {
	rsort ($addfiles);
	reset ($addfiles);
}

if ($numaddfiles) {
	for ($i = 0; $i < $numaddfiles; $i++) {
		$addfiles[$i] = $file["adddir"] . $addfiles[$i];
		if ($verbose) echof ("Found addfile '<strong>" . basename($addfiles[$i]) . "</strong>'<br>\n");
	}
	$needupdate = 1;
} else {
	if ($verbose) echof ("Found no files<br>\n");
}

if ($verbose) echof ("<br>\n");

</script><script language="php">
/*
 *	This part of the script creates the
 *	$headline[] two-dimensional array by reading headlines
 *	from files specified in $bases[] array.
 */

// Init the variables.
if ($needupdate) {
	unset ($headline);
	$hlcount = 0;

	if ($numbasefiles) {
		if ($verbose) echof ("<hr>\n");
		if ($verbose) echof ("Parsing base headlines...<br>\n");
	}

	for ($i = 0; $i < $numbasefiles; $i++) {
		if (file_exists ($bases[$i])) {
			$filename = $bases[$i];
			$fp = fopen ($bases[$i], "r");
			if ($fp) {
				while (!feof ($fp)) {
					$headline[$hlcount] = getheadline_base ($fp, $filename, $hlidlist);
					if ($headline[$hlcount]) $hlcount++;
				}
				fclose ($fp);
			}
		} else {
			echof ("Could not open file '" . $bases[$i] . "'<br>\n");
		}
	}

	if ($verbose) echof ("<br>\n");
	if ($verbose) echof ("Total number of headlines parsed - " . $hlcount . "<br><br>\n");
}

</script><script language="php">
/*
 *	  This part of the script creates the $hlidlist string,
 *	basing from $headline array.
 *
 *	The new id will be assigned to a headline post if there's no
 *	valid id for that headline.
 */


if ($needupdate) {
	$hlidlist = "";

	if ($verbose) echof ("Pass1...<br>\n");

	// Pass 1 - create the list.
	for ($i = 0; $i < $hlcount; $i++) {
		if ($headline[$i]["idid"]) {
			$hlidlist .= " " . $headline[$i]["idid"];
		}
	}

	if ($verbose) echof ($hlidlist . "<br>\n");
}

</script><script language="php">
/*
 *	This part of the script adds to the
 *	$headline[] two-dimensional array by reading headlines
 *	from files specified in $addfiles[] array.
 */

if ($needupdate) {
	if ($numaddfiles) {
		if ($verbose) echof ("<hr>\n");
		if ($verbose) echof ("Parsing add headlines...<br>\n");
	}

	$hlcountbase = $hlcount;


	for ($i = 0; $i < $numaddfiles; $i++) {
		if (file_exists ($addfiles[$i])) {
			$fp = fopen ($addfiles[$i], "r");
			if ($fp) {
				$filename = $bases[$i];
				while (!feof ($fp)) {
					$headline[$hlcount] = getheadline_add ($fp, $filename, $secoffset, $hlidlist);
					if ($headline[$hlcount]) $hlcount++;
				}
				fclose ($fp);
			}
		} else {
				echof ("Could not open file '" . $bases[$i] . "'<br>\n");
		}
	}

	$hlcountnew = $hlcount - $hlcountbase;

	if ($verbose) echof ("<br>\n");
	if ($verbose) echof ("Total number of add headlines parsed - " . $hlcountnew . "<br><br>\n");
}

</script><script language="php">
/*
 *	This part of the script updates the list, and replaces
 *	base headlines with new ones with the same ID if present.
 */

if ($needupdate) {
	if ($verbose) echof ("Pass2...<br>\n");

	for ($i = $hlcountbase; $i < ($hlcountnew + $hlcountbase); $i++) {
		if ($headline[$i]["idid"]) {

			// Check first if that id doesn't exist.
			if (!hlid_exist($headline[$i]["idid"], $hlidlist)) {
				$hlidlist .= " " . $headline[$i]["idid"];
			} else {

				echof ("Found a headline that needs to be replaced.<br>\n");

				// Delete any base headlines with that id.
				for ($j = 0; $j < $hlcountbase; $j++) {
					$deletepost = 0;
					// Skip if id doesn't match (note: convert to integers first).
					if (intval($headline[$j]["idid"]) != intval($headline[$i]["idid"])) continue;

					$temp = $headline[$j];

					$_hcount = 0;
					reset ($headline[$i]);
					while (list ($key, $val) = each ($headline[$i])) {
						if (!empty($val)) $_hcount++;
					}

					if ($_hcount == 1) {
						$deletepost = 1;
					}


					$temp = array_merge ($temp, $headline[$i]);
					// Nullify.
					unset ($headline[$i]);
					if (!$deletepost) {
						$headline[$j] = $temp;
					} else {
						echof ("Deleting post [$j]<br>\n");
						unset ($headline[$j]);
//						$headline[$j] = $headline[$i];
					}

				}
			}
		}
	}

	// Now add id for headlines needing that.
	for ($i = 0; $i < $hlcount; $i++) {
		if (!$headline[$i]["idid"]) {
			$headline[$i]["idid"] = hlid_new($hlidlist);
		}
	}

	// FIXME: Find out why I've really put the sort procedure here. It's unnecessary.
	//$hlidlist = hlid_sort ($hlidlist);

	if ($verbose) echof ($hlidlist . "<br>\n");
}

</script><script language="php">
/*
 *	This part of the script sorts the $headline[]
 *	two-dimensional array by newest entry first principle.
 */

if ($needupdate) {
	function headline_sort_bytime ($a, $b) {
		if ($a["time"] == $b["time"]) return 0;
		return ($a["time"] > $b["time"]) ? -1 : 1;
	}

	if ($hlcount) {
		if ($verbose) echof ("<hr>Sorting headline entries...<br>\n");

		reset ($headline);
		usort ($headline, "headline_sort_bytime");

		if ($verbose) {
			for ($i = 0; $i < $hlcount; $i++) {
				echof ('$headline[' . $headline[$i]["idid"] . '] = ' . $headline[$i]["time"] . "<br>\n");
			}
		}
	}
}

</script><script language="php">
/*
 *	This part of the script prepares and writes the
 *	prepared file to be read by newsreader script.
 */

// Critical script part, must not be aborted if it is possible even a little bit.
ignore_user_abort(1);


if (!$needupdate) {
	if ($verbose) echof ("<hr>News pseudocache doesn't require rebuilding.<br>\n");
} else {
	if ($verbose) echof ("<hr>Preparing to save pseudocache...<br>\n");


	reset ($headline);
	while (list ($key, $hlarray) = each ($headline)) {
		if (!$hlarray['idid']) continue;

		if (!$hlarray['section']) {
			reset ($sections);
			while (list ($section, $sarray) = each ($sections)) {
				if ($writecount[$section] >= $sections[$section]['maxheadlines']) continue;
				$writecount[$section]++;
				$_headline[$section][] = $hlarray;
			}
		} else {
			$section = strtolower ($hlarray['section']);
			if ($writecount[$section] >= $sections[$section]['maxheadlines']) continue;
			$writecount[$section]++;
			$_headline[$section][] = $hlarray;
		}
	}

	reset ($_headline);
	while (list ($section, $hlsarray) = each ($_headline)) {
		$buffercontents = serialize ($hlsarray);
		if ($verbose) echof ("Contents of prepared file for section '<strong>$section</strong>':<br>\n");
		if ($verbose) echof ("<pre style=\"background-color: rgb(192,192,192)\">" . htmlspecialchars ($buffercontents) . "</pre>\n");


		$filename = $file['basedir'] . $section . $extension["cacheext"];
		if ($verbose) echof ('Saving \'<strong>' . basename($filename) . '</strong>\'...');
		$fp = fopen ($filename, 'w');
		if (!$fp) {
			echof ("<em><strong>Script Failure</strong>: Failed to open or create file '<strong>" . $filename . "</strong>', processing aborted.</em><br>\n");
			exit;
		}
		fwrite ($fp, $buffercontents, strlen ($buffercontents));
		fclose ($fp);
		chmod ($filename, 0777);
		touch ($filename, $time_now);
		if ($verbose) echof ("Done!<br><br>\n");
	}

	unset ($_headline);
}

</script><script language="php">
/*
 *	This part of the script updates the news archive files.
 */

// We don't need to rebuild news archive base
if (!$needupdate) {
	if ($verbose) echof ("<hr>News base doesn't need rebuilding.<br>\n");
} else {
	if ($verbose) echof ("<hr>Rebuilding news base...<br>\n");

	//
	// Make backups
	//
	if ($verbose) echof ("Making backups...<br>\n");

	for ($i = 0; $i < $numbasefiles; $i++) {
		if (file_exists ($bases[$i] . ".bak")) unlink ($bases[$i] . ".bak");
		if ($verbose) echof ($bases[$i] . " to " . $bases[$i] . ".bak" . "...<br>\n");
		if (rename ($bases[$i], $bases[$i] . ".bak")) continue;
		die ("Cannot make backup of archive file!\n");
	}


	for ($i = 0; $i < $numaddfiles; $i++) {
		if (file_exists ($addfiles[$i] . ".bak")) unlink ($addfiles[$i] . ".bak");
		if (rename ($addfiles[$i], $addfiles[$i] . ".bak")) continue;
		die ("Cannot make backup of additional newspost!\n");
	}



	//
	// Create news archive data.
	//
	if ($verbose) echof ("Rebuilding news archive files...<br>\n");


	for ($i = 0; $i < $hlcount; $i++) {
		if (!$headline[$i]["idid"]) continue;
		if (!$headline[$i]["from"]) continue;

		$fn = $file["basedir"];
		$fn .= substr ($headline[$i]["time"], 0, 4) . "_" . substr ($headline[$i]["time"], 4, 2);
//		$fn .= $extension["baseext"];
		$fn .= $extension["cacheext"];

		$_hltemp = $headline[$i];
		$_hltemp['time'] = substr ($headline[$i]["time"], 6, 8);
		$_headline[] = $headline[$i];
		$_headline2[$fn][] = $_hltemp;
	}

	$filename = $file['basecache'];
	$buffercontents = serialize ($_headline);
	$fp = fopen ($filename, 'w');
	fwrite ($fp, $buffercontents, strlen ($buffercontents));
	fclose ($fp);
	chmod ($filename, 0777);
	touch ($filename, $time_now);
	unset ($filename);

	unset ($hlsarray);
	reset ($_headline2);
	while (list ($filename, $hlsarray) = each ($_headline2)) {
		$buffercontents = serialize ($hlsarray);
		$fp = fopen ($filename, 'w');
		fwrite ($fp, $buffercontents, strlen ($buffercontents));
		fclose ($fp);
		chmod ($filename, 0777);
		touch ($filename, $time_now);
	}


	unset ($filebuffer);
	for ($i = 0; $i < $hlcount; $i++) {
		if (!$headline[$i]["idid"]) continue;
		if (!$headline[$i]["from"]) continue;
		if ($verbose) echof ("[" . ($hlcount - $i) . "]...");
		$fn = $file["basedir"];
		$fn .= substr ($headline[$i]["time"], 0, 4) . "_" . substr ($headline[$i]["time"], 4, 2);
		$fn .= $extension["baseext"];

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
		if (!trim($filebuffer[$fn])) $filebuffer[$fn] =
';
; This is an news archive file that stores news posts
; for specific month.
; Which is in this case the ' . strftime ("%B %Y", mktime (12, 12, 12, (int)substr ($headline[$i]["time"], 4, 2), 12, (int)substr ($headline[$i]["time"], 0, 4))) . '.
;
; If you plan to edit this file, don\'t forget to disable word wrapping in your text processor.
;
; The file format is:

; ---                           // Three minus "-" signs are REQUIRED separators between news entries.
; TIME:dd-hh:mm;                // \'dd\' - numeric date, \'hh\' - hour, \'mm\' - minute when headline was posted.
; FROM:[author];                // Author\'s name. (example: "HMage").
; SUBJ:[subject];               // Newspost\'s subject. (example: "Microsoft shares are 56% down.").
; BODY:<p>[news body]</p>;      // Newspost\'s body. (example: "<p>Microsoft\'s shares 56% down to yesterday\'s value, which is a BIG shock for the company.<br><br>Microsoft CEO Luraye Muthacell had announced to not panic and withhold from selling their shares.<br><br>What a mess...</p>").
; IDID:[subject];               // Newspost\'s unique id, please if you don\'t know what with changing this line will do please don\'t touch.
; ---                           // Please also note that every line except triple minus end with semicolon ";" character.
;


; Here they go.
---
';
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-


		$headline[$i]["time"] = substr ($headline[$i]["time"], 6, 8);
		reset ($headline_t);
		while (list ($key2, $val2) = each ($headline_t)) {
			if (isset($headline[$i][$key2])) {
				$filebuffer[$fn] .= strtoupper($val2) . ':' . $headline[$i][$key2] . ";\n";
			}
		}
		$filebuffer[$fn] .= "---\n";

	}

	unset ($fn);
	while (list ($fn, $buffer) = each ($filebuffer)) {
		if (!trim($buffer)) continue;
		$fp = fopen ($fn, "w");
		if (!fp) die ("Cannot open archive file for writing!\n");
		// Remove CR's completely from the buffer to remove
		// annoying newline format disassociations,
		// like CRCRLF and CRLF in one file.
		// (they'll appear if THIS file is stored in Windows format)
		$buffer = str_replace ("\r\n", "\n", $buffer);

		fwrite ($fp, $buffer, strlen($buffer));
		fclose ($fp);
		chmod ($fn, 0777);
		touch ($fn, $time_now);
	}

	// REQUIRED
	touch ($file['touchfile'], $time_now);
}


// ===================================
// Show short summary-like information.
// ===================================

if ($verbose) echof ("<hr>Update complete.<br>\n");
else {
	if ($needupdate) {
		echof ("done.<br><br>\n");
	} else {
		echof ("skip.<br><br>\n");
	}
}

if ($needupdate) {
	echof ("News archive have been rebuilt.<br>\n");
	echof ("Number of processed headlines - <strong>" . $hlcount . "</strong>.<br>\n");
} else {
	echof ("News base didn't require rebuilding.<br>\n");
}

echof ("<hr>Thank you.<br>\n");

if ($verbose) echof ("<small>" . microtime() . "</small><br>\n");

</script><script language="php">

if (isset($calledfromphp)) {
	ob_end_clean();
} else {
	ob_end_flush();
}
// Don't process anything below
return;
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>NewsScript Updater.</title>
</head>

<body vlink="#0000FF" alink="#000080">

<p align="center"><strong>Please don't modify this file if you're not sure what you will
cause by modifying it.</strong></p>

<p align="center"><strong>Пожалуйста не редактируйте этот
файл если вы не уверены в последствиях.</strong></p>
</body>
</html>
