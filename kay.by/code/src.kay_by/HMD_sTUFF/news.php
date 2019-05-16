<script language="php">
/* =============================================================
 *      News Headlines reader script v1.0
 *      (C)opyright 2000 HMage, Minsk, Belarus.
 * =============================================================
 */

// SET THIS TO '1' IF YOU HAVE PROBLEMS WITH THE NEWSREADER TO
// SEE WHAT'S GOING ON
$verbose = 0;

// ==============================================================
if (!$verbose) {
        error_reporting (341);
}

require_once ("cgi-bin/news.inc");
function news_obhandler ($buffer) {
        $buffer = trim($buffer);
        header ("Accept-Ranges: bytes");
        header ("Cache-Control: public, max-age=2001");
        header ("Content-Length: " . strlen($buffer));
        header ("Content-MD5: " . md5($buffer));
        header ("ETag: \"" . crc32($buffer) . md5($buffer) . "\"");
        header ("Expires: " . gmdate("D, d M Y H:i:s", time() + 86400) . " GMT");
        header ("Vary: ETag");
        return $buffer;
}

function showheader() {
        $header =& $GLOBALS["header"];
        global $hlcount;
        if (isset($header)) {
                $header = str_replace ("%MAXHL%", intval($hlcount), $header);
                echo $header . "\n";
                unset ($GLOBALS["header"]);
        }
}

function showfooter() {
        $footer =& $GLOBALS["footer"];
        if (isset($footer)) {
                nr_echof ($footer . "\n");
                unset ($GLOBALS["footer"]);
        }
}


// =====================
// void ndie ($message);
// =====================
// Call this function instead of die() in this script.
function ndie ($message) {
        showheader();
        echo $message;
        showfooter();
        die ("");
}


function nr_echof ($string) {
        static $firsttime = 1;
        if ($firsttime) {
                showheader();
                $firsttime = 0;
        }
        echo $string;
}


if ($settings['news_useob']) {
        ob_start("news_obhandler");
}
</script>
<script language="php">
/*
 * This part of the script inits the variables and defines the script behaviour.
 */


$showarchive = "";

$section = $settings['news_defaultsection'];
if (isset($HTTP_GET_VARS['section'])) {
        $_tempsection = strtolower($HTTP_GET_VARS['section']);
        if (isset($sections[$_tempsection])) {
                $section = $_tempsection;
        }
        unset ($_tempsection);
}

if (isset ($HTTP_GET_VARS["archive"])) {
        $showarchive = substr ($HTTP_GET_VARS["archive"], 0, 7) . $extension['cacheext'];
//      $showarchive = substr ($HTTP_GET_VARS["archive"], 0, 7) . $extension["baseext"];
        if (!valid_newsbasename ($showarchive)) {
                unset ($bases);
                $filenum = getbasefiles ($bases);
                if ($filenum) {
                        $showarchive = $bases[$filenum - 1];
                } else {
                        $showarchive = "nonews";
                }
        }


        if ($verbose) {
                echo "I'm asked to show an archive instead of current news...<br>\n";
                echo "And it's filename is '<strong>" . $showarchive . "</strong>'...<br>\n";
                if (valid_newsbasename ($showarchive)) {
                        echo "The filename is right.<br>\n";
                } else {
                        echo "The filename is wrong.<br>\n";
                }
        }
}

if (!$showarchive) {
        $filename = $file['template_' . $section];
} else {
        $filename = $file['template_' . $section . 'arch'];
}

setheaderfooter ($header, $footer, $filename, '%HMDNEWS%');

</script>
<script language="php">


// DEBUG LINE
if ($verbose) echo "Processing Author list...<br>";

unset ($author);
$authcount = getuserarray ($author);
</script><script language="php">
/*
 *      This part of the script reads the template into the buffer.
 */

if (!$showarchive) {
        $filename = $file['template_' . $section . 'hl'];
} else {
        $filename = $file['template_' . $section . 'archhl'];
}

if (file_exists($filename)) {
        $fp = fopen ($filename, "r");
        if ($fp) {
                $templatebuffer = gettemplate ($filename);
        } else {
                echo $note["NOTPLNEWS"];
        }
} else {
        echo $note["NOTPLNEWS"];
}

</script>
<script language="php">
/*
 *      This part of the script reads the headlines.
 */

unset ($headline);

if (!$showarchive) {
        $filename = $file['basedir'] . $section . $extension["cacheext"];
} else {
        $filename = $file["basedir"] . $showarchive;
}

if (!file_exists ($filename)) {
        if ($verbose) {
                ndie ("File '" . $filename . "' doesn't exist!<br>\n");
        } else {
                if (!$showarchive) {
                        ndie ($language["news_nonews"] . "<br>\n");
                } else {
                        ndie ("Incorrect parameter.<br>\n");
                }
        }
}


// Calculate the $date variable. FIXME: remove some redundant dependencies.
if ($showarchive) {
        $date = substr (basename($showarchive), 0, 4) . substr (basename($showarchive), 5, 2);
}


// open headline entries file.
$fp = fopen ($filename, "r");
if (!$fp)
        ndie ("Unable to open file '" . $filename . "'<br>\n");


// parse headline entries

$headline = unserialize (fread ($fp, filesize($filename)));
$hlcount = sizeof($headline);

while (list ($key, $value) = each ($headline)) {
        $headline[$key]['body'] = MakeBodyPretty ($value['body']);
        if ($showarchive) $headline[$key]['date'] = $date;
}

// close headline entries file.
fclose ($fp);

if (!$hlcount) ndie ($language["news_nonews"] . "<br>\n");

// DEBUG LINE
if ($verbose) echo "Total number of headlines in file '" . basename($filename) . "' - " . $hlcount . "<br><br>\n";

</script>
<script language="php">
/*
 *      This part of the script outputs the headlines.
 */
if ($showarchive) {
        $header = str_replace ("%MONTH%", substr($date, 4, 2), $header);
        $header = str_replace ("%MM%", substr($date, 4, 2), $header);
        $header = str_replace ("%M%", (int)substr($date, 4, 2), $header);
        $header = str_replace ("%YYYY%", substr($date, 0, 4), $header);
} else {
        $header = str_replace ("%MAXHL%", $hlcount, $header);
}
//showheader();

for ($i = 0; $i < $hlcount; $i++) {
        // Pad the headline array into the class.
        if (!$headline[$i]['time']) continue;
        if (isset($headline[$i]['section'])) {
                if ($section != $headline[$i]['section']) {
                        unset ($headline[$i]);
                        continue;
                }
        }
        $hlcls[$i] = parsehl ($headline[$i], $author, $authcount);
        $hlcls[$i]->html = $templatebuffer;
        $hlcls[$i] = parsetpl ($hlcls[$i]);

        // Output the contents.
        nr_echof ($hlcls[$i]->html . "\n");
}


// Add a browse archive links
unset ($browsearchivelink);
if (((!$settings["news_nobrowsearchive"]) || ($showarchive)) && ($sections[$section]['type'] == 0) && ($sections[$section]['maxheadlines'] < $hlcount)) {
        $filename = $file['basecache'];
        $fp = fopen ($filename, 'r');
        $_baheadlines = unserialize(fread ($fp, filesize ($filename)));
        fclose ($fp);

        reset ($_baheadlines);
        while (list ($key, $valarray) = each ($_baheadlines)) {
                if (isset($valarray['section'])) {
                        if ($section != $valarray['section']) {
                                continue;
                        }
                }
                $_date = substr ($valarray["time"], 0, 4) . "_" . substr ($valarray["time"], 4, 2) . $etension['cacheext'];;
//              $date = substr ($valarray["time"], 0, 4) . "_" . substr ($valarray["time"], 4, 2) . $extension["baseext"];
                $_badates[$_date]++;
        }

        $arraysize = sizeof ($_badates);
        if ($section == $settings['news_defaultsection']) {
                $balinkprefix = "<a href=\"" . $settings["news_browsearchive"] . "&archive=";
        } else {
                $balinkprefix = "<a href=\"" . $settings["news_browsearchive"] . "&section=" . $section . "&archive=";
        }

        unset ($linkcount);
        reset ($_badates);
        while (list ($_date, $count) = each ($_badates)) {
                $linkcount++;
                if (!strcasecmp ($showarchive, $_date)) {
                        $browsearchivelink .= "<span style=\"text-decoration: line-through\">";
                        $browsearchivelink .= substr ($_date, 5, 2);
                        $browsearchivelink .= "/";
                        $browsearchivelink .= substr ($_date, 0, 4);
                        $browsearchivelink .= "</span>";
                } else {
                        $browsearchivelink .= $balinkprefix;
                        $browsearchivelink .= substr ($_date, 0, 7);
                        $browsearchivelink .= "\">";
                        $browsearchivelink .= substr ($_date, 5, 2);
                        $browsearchivelink .= "/";
                        $browsearchivelink .= substr ($_date, 0, 4);
                        $browsearchivelink .= "</a>";
                }

                if ($linkcount != $arraysize) $browsearchivelink .= $language["news_browsearchiveseparator"];
        }
        $browsearchivelink = $language["news_browsearchiveprefix"] . $browsearchivelink . $language["news_browsearchivesuffix"];

        $pos = strpos ($header, "%HMDARCHLINK%");
        if ($pos === false) {
                $pos = strpos ($footer, "%HMDARCHLINK%");
                if ($pos === false) {
                        nr_echof ($browsearchivelink);
                }
        }
}

$header = str_replace ("%HMDARCHLINK%", $browsearchivelink, $header);
$footer = str_replace ("%HMDARCHLINK%", $browsearchivelink, $footer);

// Add a footer.
if ($showarchive) {
        $footer = str_replace ("%MONTH%", substr($date, 4, 2), $footer);
        $footer = str_replace ("%MM%", substr($date, 4, 2), $footer);
        $footer = str_replace ("%M%", (int)substr($date, 4, 2), $footer);
        $footer = str_replace ("%YYYY%", substr($date, 0, 4), $footer);
} else {
        $footer = str_replace ("%MAXHL%", $hlcount, $footer);
}

showfooter();
ob_end_flush();
// Don't process anything below.
return;
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>NewsScript Reader</title>
</head>

<body vlink="#0000FF" alink="#000080">

<p align="center"><strong>Please don't modify this file if you're not sure what you will
cause by modifying it.</strong></p>

<p align="center"><strong>Пожалуйста не редактируйте этот
файл если вы не уверены в последствиях.</strong></p>
</body>
</html>
