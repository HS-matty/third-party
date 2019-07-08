<script language="php">
/* =============================================================
 *      News script manager v1.02
 *      (C)opyright 2000 HMage, Minsk, Belarus.
 * =============================================================
 */

// ------------
   $debug = 0;  // Set this to 1 when you're debugging or having problems.
// ------------



if (!$debug) error_reporting (341);
require_once("cgi-bin/news.inc");

function newsman_obhandler ($buffer) {
        global $docache;

        header ("Accept-Ranges: bytes");
        header ("Cache-Control: public");
        if ($docache) {
                header ("Expires: " . date ("D, d M Y H:i:s", time() + 86400) . " GMT");
        } else {
                header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        }
        header ("Content-Length: " . strlen($buffer));
        header ("Content-MD5: " . md5($buffer));
        header ("ETag: \"" . crc32($buffer) . md5($buffer) . "\"");
        header ("Vary: ETag");
        return $buffer;
}

function qget_headlines () {
        global $file;
        global $extension;


        $filename = $file['basecache'];
        $fp = fopen ($filename, 'r');
        $filecache = unserialize (fread ($fp, filesize ($filename)));
        fclose ($fp);
        return $filecache;
}

$filename = $file['managertemplatedir'] . "manager.html";
setheaderfooter ($header, $footer, $filename, '%NEWSMAN%');
ob_start ("newsman_obhandler");
setcookie ("CookiePresenceTest", "test");

unset ($sidarray);
getsids ($sidarray);

if (empty ($HTTP_COOKIE_VARS["sid"])) {
        $sid = "";
} else {
        $sid = $HTTP_COOKIE_VARS["sid"];
        if (!$sidarray[$sid]) $sid = "";
}

// Keep timeouts from firing if the user is navigating the manager.
setsids ($sidarray, $sid);

$username = "";
$user_admin = 0;
$user_nomail = 0;


unset ($author);
$authcount = getuserarray ($author);

// Send a notice to client that this page is uncacheable.
if ($debug) {
        header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header ("Cache-Control: no-cache, must-revalidate");
        header ("Pragma: no-cache");
}




function makebodyeditable ($body) {
        if (!strcasecmp ("<p>", substr ($body, 0, 3))) {
                $body = substr ($body, 3, -4);
        }
        $body = str_replace ("<BR>", "\n", $body);
        $body = str_replace ("<br>", "\n", $body);
        $body .= "\n";
        return $body;
}

</script><script language="php">
// === routine: $do and $show management ===
// === ================================= ===
$do = "";
$do_a = array (
// -------------------------------------------------
        "login"                 =>      "1",
        "postnews"              =>      "1",
        "postedit"              =>      "1",
        "postkill"              =>      "1",

        "userchange"            =>      "1",

        "logout"                =>      "1",

        // Admin ones
        "sendtemplates"         =>      "1",
        "auseradd"              =>      "1",
        "auserchange"           =>      "1",
        "auserkill"             =>      "1",
// -------------------------------------------------
);

$show = ""; // $show depends from $do
$show_a = array (
// -------------------------------------------------
        "login"                 =>      "2", // 2 - redirect to it.

        "menu"                  =>      "2", // 2 - redirect to it.

        "postnews"              =>      "3", // 3 - do caching.

        "posteditlist"          =>      "1",
        "postedit"              =>      "3", // 3 - do caching.

        "postkilllist"          =>      "1",
        "postkill"              =>      "1",

        "userchange"            =>      "3", // 3 - do caching.

        // Admin's menu
        "sendtemplates"         =>      "1",

        "auseradd"              =>      "3", // 3 - do caching.
        "auserchangelist"       =>      "1",
        "auserchange"           =>      "3", // 3 - do caching.
        "auserkilllist"         =>      "1",
        "auserkill"             =>      "1",
// -------------------------------------------------
);

// ==============================================================
if ($debug) {
        echo "<small>DEBUG: POST method values:</small><br>";
        reset ($HTTP_POST_VARS);
        while (list ($key, $val) = each ($HTTP_POST_VARS)) {
                echo "[$key] => $val<br>";
        }
        echo "<small>DEBUG: GET method values:</small><br>";
        reset ($HTTP_GET_VARS);
        while (list ($key, $val) = each ($HTTP_GET_VARS)) {
                echo "[$key] => $val<br>";
        }
}

// If in GET there are no &action= or &show= then show a login.
// Look up from array of valid &action= and &show=
// If either '&action=' or '&show=' is invalid then show an error.
if (isset ($HTTP_GET_VARS["action"])) {
        // Check for valid action
        if ($do_a[$HTTP_GET_VARS["action"]]) {
                $do = $HTTP_GET_VARS["action"];
        } else {
                $show = "error";
        }
} else if (isset ($HTTP_POST_VARS["action"])) {
        // Check for valid action on POST, but
        // GET '&action=' must be here too.
        if ($do_a[$HTTP_GET_VARS["action"]] != 0) {
                $do = $HTTP_GET_VARS["action"];
        } else {
                $show = "error";
        }
} else if (isset ($HTTP_GET_VARS["show"])) {
        // Check for valid show
        if ($show_a[$HTTP_GET_VARS["show"]] != 0) {
                if ($show_a[$HTTP_GET_VARS["show"]] == 3) $docache = 1;
                $show = $HTTP_GET_VARS["show"];
        } else {
                $show = "error";
        }
} else {
        $do = "";
        // If session is is supplied, then show menu, else show login.
        if (!$sid) $show = "login";
        else $show = "menu";
}
</script><script language="php">
// === routine: session support ===
// === ======================== ===

// Person didn't login yet when on login dialogue.
// So just skip the check when $show == "login";
if ($show != "login") {
        // Check for cookies support.
        if (empty ($HTTP_COOKIE_VARS["CookiePresenceTest"])) {
                $do = "";
                $show = "nocookie";
        } else {
                if ($HTTP_COOKIE_VARS["CookiePresenceTest"] != "test") {
                        $do = "";
                        $show = "nocookie";
                }
        }

        // Check for valid session id.
        // $sid will be of zero length if session id isn't valid.
        if (!$sid) {
                // Olalala... You're trying to get in here without
                // session id cookie... Cut him off.
                if (!$debug) {
                        $do = "login";
                        $show = "relogin";
                }
        }

        @reset ($sidarray);
        while (list ($key, $val) = @each ($sidarray)) {
                if ($key == $sid) {
                        $username = $val;
                        break;
                }
        }

        if (!$username) {
                // Session id is invalid.
                if (!$debug) {
                        $do = "login";
                        $show = "relogin";
                }
        } else {
                for ($i = 0; $i < $authcount; $i++) {
                        if ($username == $author[$i]["name"]) {
                                $user_admin = $author[$i]["admin"];
                                $usermail = $author[$i]["mail"];
                                $user_nomail = $author[$i]["nomail"];
                                $user = $author[$i];
                                break;
                        }
                }
        }

        if ($debug) {
                $username = "HMage";
                $user_admin = 1;
                $usermail = "hmd@mail.ru";
                $user_nomail = 0;
        }
}

</script><script language="php">
// === do: login ===
// === ========= ===

// Checks is login valid and
// if valid sets a uniqie session id to client browser.
// TODO: append an username checksum there too to prevent unwanted
//       session id reuse.
if ($do == "login") {

        // Do validity checks on POST variables.
        $authnumber = 0;
        $authvalid = 0;

        // Check username.
        $un = trim($HTTP_POST_VARS["login_username"]);
        $unValid = 0;
        if ($un) {
                for ($i = 0; $i < $authcount; $i++) {
                        if (!strcasecmp ($author[$i]["name"], $un)) {
                                $unValid = 1;
                                $authnumber = $i + 1;
                                break;
                        }
                }
        }

        $password = trim($HTTP_POST_VARS["login_password"]);
        $pav = 0;
        if (($unValid) && ($password)) {
                if (!strcasecmp ($author[$authnumber - 1]["pass"], $password)) {
                        $pav = 1;
                }
        }

        if ($unValid && $pav) $authvalid = 1;


        if ($authvalid) {
                // Everything is ok, green light.
                $sid = md5 (uniqid (rand(), 1));
                $username = $author[$authnumber - 1]["name"];

                // Check for sanity.
                reset ($sidarray);
                while (list ($key, $val) = each ($sidarray)) {
                        if ($val == $username) {        // If logon was done before, clear it.
                                unset ($sidarray[$key]);
                        }
                        if ($key == $sid) {             // If session id is already used, pick up another one.
                                $sid = md5 (uniqid (rand(), 1));
                        }
                }

                $sidarray[$sid] = $username;

                if ($debug) echo "Hello, " . $username . "! I'm now going to give you this session id: <code>" . $sid . "</code>. Have a nice day!<br>\n";

                // Send a session id cookie.
                setcookie ("sid", $sid);
                setsids ($sidarray, $sid);
                $show = "menu";
        } else {
                $show = "relogin";
        }
}

</script><script language="php">
// === do: postnews ===
// === ============ ===
// Part one

if ($do == "postnews") {
        $section = $settings['news_defaultsection'];
        if (isset($HTTP_GET_VARS['section'])) {
                $_tempsection = strtolower($HTTP_GET_VARS['section']);
                if (isset($sections[$_tempsection])) {
                        $section = $_tempsection;
                }
                unset ($_tempsection);
        }
        if (empty($user['sections'][$section]) && (!$user_admin)) $show = "error";

        if ($show != "error") {
                if (empty($HTTP_POST_VARS["postnews_preview"]) && empty($HTTP_POST_VARS["postnews_submit"])) {
                        $show = "error";
                } else if (empty($HTTP_POST_VARS["postnews_subject"])) {
                        $show = "repostnews";
                } else if (!strlen(trim($HTTP_POST_VARS["postnews_subject"]))) {
                        $show = "repostnews";
                } else if (empty($HTTP_POST_VARS["postnews_time"])) {
                        $show = "repostnews";
                } else if (!strlen(trim($HTTP_POST_VARS["postnews_time"]))) {
                        $show = "repostnews";
                } else if (empty($HTTP_POST_VARS["postnews_body"])) {
                        $show = "repostnews";
                } else if (!strlen(trim($HTTP_POST_VARS["postnews_body"]))) {
                        $show = "repostnews";
                } else {
                        if (empty($HTTP_POST_VARS["postnews_preview"])) {
                                if (empty($HTTP_POST_VARS["postnews_submit"])) {
                                        $show = "repostnews";
                                } else {
                                        $do = "postnewssubmit";
                                }
                        } else {
                                $do = "postnewspreview";
                        }
                }

                if (isset($HTTP_POST_VARS["postnews_nl2br"])) {
                        $pn_nl2br = "checked";
                } else {
                        $pn_nl2br = "";
                }
                $pn_body = trim($HTTP_POST_VARS["postnews_body"]);
                $pn_subject = trim($HTTP_POST_VARS["postnews_subject"]);
                $pn_time = trim($HTTP_POST_VARS["postnews_time"]);
                if ($user_admin)
                        $pn_from = trim($HTTP_POST_VARS["postnews_from"]);
                else $pn_from = $username;
        }
}



// === do: postnews ===
// === ============ ===
// Part two

if ($do == "postnewssubmit") {
        if ($pn_nl2br) {
                $pn_body = nl2br ($pn_body);
        }
        $pn_body = MakeBodyPretty ($pn_body);

        if (!$user_admin)
                $filebuffer .= "FROM:" . $username . ";\n";
        else $filebuffer .= "FROM:" . $pn_from . ";\n";
        $filebuffer .= "TIME:" . $pn_time .";\n";
        $filebuffer .= "SUBJ:" . $pn_subject . ";\n";
        $filebuffer .= "BODY:" . $pn_body . ";\n";
        $filebuffer .= "SECTION:" . $section . ";\n";
        if ($debug) echo "<pre>" . htmlentities ($filebuffer) . "</pre>";

        $fp = fopen ($file["adddir"] . uniqid("") . $extension["addext"], "w");
        fwrite ($fp, $filebuffer, strlen($filebuffer));
        fclose ($fp);
        unset ($filebuffer);

        $calledfromphp = 1;
        include ($settings['file_newsupdate']);

        $show = "ultimate";
}



// === do: postnews ===
// === ============ ===
// Part three

if ($do == "postnewspreview") {
        $show = "postnewspreview";
}

</script><script language="php">
// === do: postedit ===
// === ============ ===
// Part one

if ($do == "postedit") {
        $section = $settings['news_defaultsection'];
        if (isset($HTTP_GET_VARS['section'])) {
                $_tempsection = strtolower($HTTP_GET_VARS['section']);
                if (isset($sections[$_tempsection])) {
                        $section = $_tempsection;
                }
                unset ($_tempsection);
        }
        if (empty($user['sections'][$section]) && (!$user_admin)) $show = "error";

        if ($show != "error") {
                $greenlight = 0;
                if (!$HTTP_POST_VARS["postedit_preview"] && !$HTTP_POST_VARS["postedit_submit"])
                        $show = "error";

                if (!$HTTP_POST_VARS["postedit_subject"])
                        $show = "repostnews";
                if (!$HTTP_POST_VARS["postedit_body"])
                        $show = "repostnews";
                if (!$HTTP_POST_VARS["postedit_from"])
                        $show = "repostnews";
                if (!$HTTP_POST_VARS["postedit_time"])
                        $show = "repostnews";

                $fp = fopen ("cgi-bin/" . $username . ".peid", "r");
                if (!$fp) $show = "error";
                else {
                        $postid = trim(fgets($fp, 65535));
                        settype ($postd, "integer");
                        if (!$postid) $show = "error";
                        else {
                                if ($postid != $HTTP_GET_VARS["id"]) $show = "error";
                        }
                        fclose ($fp);
                }


                if (!$user_admin) {
                        if ($HTTP_POST_VARS["postedit_from"] == $username) {
                                $greenlight = 1;
                        }
                } else {
                        $greenlight = 1;
                }

                if ($debug) $greenlight = 1;

                if ($greenlight) {
                        if (($show != "repostnews") && ($show != "error")) {
                                if ($HTTP_POST_VARS["postedit_preview"])
                                        $do = "posteditpreview";
                                else $do = "posteditsubmit";

                                if (isset($HTTP_POST_VARS["postedit_nl2br"]))
                                        $pe_nl2br = "checked";
                                else $pe_nl2br = "";

                                $pe_time = trim($HTTP_POST_VARS["postedit_time"]);
                                $pe_idid = $postid;
                                $pe_from = trim($HTTP_POST_VARS["postedit_from"]);
                                $pe_body = trim($HTTP_POST_VARS["postedit_body"]);
                                $pe_subject = trim($HTTP_POST_VARS["postedit_subject"]);
                        }
                } else {
                        $show = "error";
                }
        }
}


// === do: postedit ===
// === ============ ===
// Part two

if ($do == "posteditsubmit") {
        if ($pe_nl2br) {
                $pe_body = nl2br ($pe_body);
        }
        $pe_body = MakeBodyPretty ($pe_body);

        $filebuffer  = "IDID:" . $pe_idid . ";\n";
        $filebuffer .= "FROM:" . $pe_from . ";\n";
        $filebuffer .= "SUBJ:" . $pe_subject . ";\n";
        $filebuffer .= "BODY:" . $pe_body . ";\n";
        $filebuffer .= "TIME:" . $pe_time . ";\n";
        $filebuffer .= "SECTION:" . $section . ";\n";
        if ($debug) echo "<pre>" . htmlentities ($filebuffer) . "</pre>";

        $fp = fopen ($file["adddir"] . uniqid("") . $extension["addext"], "w");
        fwrite ($fp, $filebuffer, strlen($filebuffer));
        fclose ($fp);
        unset ($filebuffer);

        $calledfromphp = 1;
        include $settings['file_newsupdate'];

        $show = "ultimate";
}



// === do: postedit ===
// === ============ ===
// Part three

if ($do == "posteditpreview") {
        $show = "posteditpreview";
}

</script><script language="php">
// === do: postkill ===
// === ============ ===

if ($do == "postkill") {
        $section = $settings['news_defaultsection'];
        if (isset($HTTP_GET_VARS['section'])) {
                $_tempsection = strtolower($HTTP_GET_VARS['section']);
                if (isset($sections[$_tempsection])) {
                        $section = $_tempsection;
                }
                unset ($_tempsection);
        }
        if (empty($user['sections'][$section]) && (!$user_admin)) $show = "error";

        if ($show != "error") {
                $greenlight = 0;
                if ($HTTP_POST_VARS["postkill_yes"]) {
                        $greenlight = 1;
                } else  if ($HTTP_POST_VARS["postkill_no"]) {
                        $greenlight = 0;
                        $show = "menu";
                } else {
                        $show = "error";
                }

                if (!$HTTP_GET_VARS["id"]) {
                        $show = "error";
                        $greenlight = 0;
                }

                if ($greenlight) {
                        $hlcount = 0;
                        $hlidlist = "";
                        $headline = qget_headlines();   //QUickly SEt HEadLInes

                        reset ($headline);
                        while (list ($key, $val) = each ($headline)) {
                                if (isset ($headline[$key]["time"])) {
                                        $hlcount++;
                                }
                        }

                        for ($i = 0; $i < $hlcount; $i++) {
                                if ($headline[$i]["idid"] == $HTTP_GET_VARS["id"]) {
                                        $postindex = $i;
                                        $postid = $headline[$i]["idid"];
                                        break;
                                }
                        }

                        if (($postid) && (!$user_admin) && (!$debug)) {
                                if ($username != $headline[$postindex]["from"]) {
                                        $show = "error";
                                        $postid = 0;
                                        unset ($postindex);
                                }
                        }


                        if ($postid) {
                                $filebuffer = "IDID:" . $postid . ";\n";
                                if ($debug) echo "<pre>" . htmlentities ($filebuffer) . "</pre>";

                                $fp = fopen ($file["adddir"] . uniqid("") . $extension["addext"], "w");
                                fwrite ($fp, $filebuffer, strlen($filebuffer));
                                fclose ($fp);
                                unset ($filebuffer);

                                unset ($headline);
                                unset ($hlcount);
                                unset ($bases);
                                unset ($hlidlist);
                                $calledfromphp = 1;
                                include $settings['file_newsupdate'];

                                $show = "ultimate";
                        }
                }
        }
}

</script><script language="php">
// === do: userchange ===
// === ============== ===

if ($do == "userchange") {
        $noprocess = 0;
        if (!strlen(trim($HTTP_POST_VARS["userchange_name"]))) {
                $show = "repostnews";
                $noprocess = 1;
        }

        if (trim($HTTP_POST_VARS["userchange_pass"]) == "12345678901234") $HTTP_POST_VARS["userchange_pass"] = "";
        if (trim($HTTP_POST_VARS["userchange_pass2"]) == "12345678901234") $HTTP_POST_VARS["userchange_pass2"] = "";

        if (strcasecmp($HTTP_POST_VARS["userchange_pass"], $HTTP_POST_VARS["userchange_pass2"])) {
                $show = "reucp";
                $noprocess = 1;
        }

        for ($i = 0; $i < $authcount; $i++) {
                if (strcasecmp ($author[$i]["name"], trim($HTTP_POST_VARS["userchange_name"]))) continue;
                if (strcasecmp ($author[$i]["name"], $username)) {
                        $show = "reucn";
                        $noprocess = 1;
                }
        }

        if (!$noprocess) {
                $newname = trim($HTTP_POST_VARS["userchange_name"]);
                $newmail = trim($HTTP_POST_VARS["userchange_mail"]);
                $new_nomail =!(!$HTTP_POST_VARS["userchange_nomail"]); // I need an integer value :)
                for ($i = 0; $i < $authcount; $i++) {
                        if ($username == $author[$i]["name"]) {
                                $authoff = $i;
                                break;
                        }
                }

                $newpass = $author[$authoff]["pass"];

                // If there's no new password, leave the old one.
                if (trim($HTTP_POST_VARS["userchange_pass"])) {
                        $newpass = trim($HTTP_POST_VARS["userchange_pass"]);
                }


                if ($debug) {
                        echo "Old username - '<strong>" . $username . "</strong>'. New username - '<strong>" . $newname . "</strong>'<br>\n";
                        echo "Old usermail - '<strong>" . $usermail . "</strong>'. New usermail - '<strong>" . $newmail . "</strong>'<br>\n";
                        echo "Old nomail - '<strong>" . $user_nomail . "</strong>'. New nomail - '<strong>" . $new_nomail . "</strong>'<br>\n";
                        echo "Old userpass - '<strong>" . $author[$authoff]["pass"] . "</strong>'. New userpass - '<strong>" . $newpass . "</strong>'<br>\n";
                }


                $author[$authoff]["name"] = $newname;
                $author[$authoff]["mail"] = $newmail;
                $author[$authoff]["nomail"] = $new_nomail;
                $author[$authoff]["pass"] = $newpass;

                // Don't do that on debug.
                if (!$debug) {
                        setuserarray ($author);

                        $username = $newname;
                        $usermail = $newmail;
                        $user_nomail = $new_nomail;
                        $sidarray[$sid] = $username;
                        setsids ($sidarray, $sid);
                }

                $show = "menu";
        }
}

</script><script language="php">
// === do: logout ===
// === ========== ===

if ($do == "logout") {
        unlink ("cgi-bin/" . $username . ".peid");
        unlink ("cgi-bin/" . $username . ".ucon");
        unlink ("cgi-bin/" . $username . ".ukon");
        $do = "redirect";
        $redirectto = $settings["newsman_logout"];
        $redirectto = str_replace ("%PHP_SELF%", $PHP_SELF, $redirectto);

        $sidarray[$sid] = "";
        setsids ($sidarray, $sid);
        setcookie ("sid", "");

}

</script><script language="php">
// === do: auseradd ===
// === ============ === (admin only)

if ($do == "auseradd") {
        if ($user_admin) {
                $noprocess = 0;
                if (!strlen(trim($HTTP_POST_VARS["auseradd_name"]))) {
                        $show = "repostnews";
                        $noprocess = 1;
                }

                if (!strlen(trim($HTTP_POST_VARS["auseradd_pass"]))) {
                        $show = "repostnews";
                        $noprocess = 1;
                }

                for ($i = 0; $i < $authcount; $i++) {
                        if (strcasecmp ($author[$i]["name"], trim($HTTP_POST_VARS["auseradd_name"]))) continue;
                        if (strcasecmp ($author[$i]["name"], $username)) {
                                $show = "reucn";
                                $noprocess = 1;
                        }
                }

                if (!$noprocess) {
                        $newname = trim($HTTP_POST_VARS["auseradd_name"]);
                        $newmail = trim($HTTP_POST_VARS["auseradd_mail"]);
                        $new_nomail = empty($HTTP_POST_VARS["auseradd_nomail"]) ? 0 : 1;
                        $new_admin = empty($HTTP_POST_VARS["auseradd_admin"]) ? 0 : 1;
                        $newpass = trim($HTTP_POST_VARS["auseradd_pass"]);

                        // New account, so increment the count too.
                        $authoff = ++$authcount;

                        if ($debug) {
                                echo "Old username - '<strong>" . $username . "</strong>'. New username - '<strong>" . $newname . "</strong>'<br>\n";
                                echo "Old usermail - '<strong>" . $usermail . "</strong>'. New usermail - '<strong>" . $newmail . "</strong>'<br>\n";
                                echo "Old nomail - '<strong>" . $user_nomail . "</strong>'. New nomail - '<strong>" . $new_nomail . "</strong>'<br>\n";
                                echo "Old userpass - '<strong>" . $author[$authoff]["pass"] . "</strong>'. New userpass - '<strong>" . $newpass . "</strong>'<br>\n";
                        }

                        $author[$authoff]["name"] = $newname;
                        $author[$authoff]["mail"] = $newmail;
                        $author[$authoff]["nomail"] = $new_nomail;
                        $author[$authoff]["admin"] = $new_admin;
                        $author[$authoff]["pass"] = $newpass;
                        reset ($sections);
                        while (list ($section, $sarray) = each ($sections)) {
                                if (isset($HTTP_POST_VARS['auseradd_section_' . $section])) {
                                        $author[$authoff]['sections'][$section] = $section;
                                } else unset ($author[$authoff]['sections'][$section]);
                        }

                        // Actually do that only on debug.
                        if (!$debug) {
                                setuserarray ($author);
                        }

                        $show = "menu";
                }
        } else {
                $show = "error";
        }
}

</script><script language="php">
// === do: auserchange ===
// === =============== === (admin only)

if ($do == "auserchange") {
        if ($user_admin) {
                $noprocess = 0;
                if (!strlen(trim($HTTP_POST_VARS["auserchange_name"]))) {
                        $show = "repostnews";
                        $noprocess = 1;
                }

                if (!strlen(trim($HTTP_POST_VARS["auserchange_pass"]))) {
                        $show = "repostnews";
                        $noprocess = 1;
                }

                $fp = fopen ("cgi-bin/" . $username . ".ucon", "r");
                if (!$fp) $show = "error";
                else {
                        $oldname = trim(fgets($fp, 65535));
                        if (!$oldname) {
                                $show = "error";
                                $noprocess = 1;
                        } else {
                                if ($oldname != $HTTP_GET_VARS["who"]) {
                                        $show = "error";
                                }
                        }
                        fclose ($fp);
                }

                $newname = trim($HTTP_POST_VARS["auserchange_name"]);
                $newmail = trim($HTTP_POST_VARS["auserchange_mail"]);

                // I need an integer value ;)
                $new_nomail = !(!$HTTP_POST_VARS["auserchange_nomail"]);

                for ($i = 0; $i < $authcount; $i++) {
                        // If we're trying to change the name to a one that already exists, error.
                        if (!strcasecmp ($author[$i]["name"], $newname)) {
                                if (strcasecmp ($oldname, $newname)) {
                                        $show = "reucn";
                                        $noprocess = 1;
                                }
                        }
                }

                if (!$noprocess) {

                        $authoff = -1;
                        for ($i = 0; $i < $authcount; $i++) {
                                if ($oldname == $author[$i]["name"]) {
                                        $authoff = $i;
                                        break;
                                }
                        }
                        if ($author[$i]["admin"]) {
                                $show = "error";
                                $authoff = -1;
                                $newname = "";
                        }

                        $newpass = trim($HTTP_POST_VARS["auserchange_pass"]);

                        if ($debug) {
                                echo "Old username - '<strong>" . $oldname . "</strong>'. New username - '<strong>" . $newname . "</strong>'<br>\n";
                                echo "New usermail - '<strong>" . $newmail . "</strong>'<br>\n";
                                echo "New nomail - '<strong>" . $new_nomail . "</strong>'<br>\n";
                                echo "New userpass - '<strong>" . $newpass . "</strong>'<br>\n";
                        }


                        $author[$authoff]["name"] = $newname;
                        $author[$authoff]["mail"] = $newmail;
                        $author[$authoff]["nomail"] = $new_nomail;
                        $author[$authoff]["pass"] = $newpass;
                        reset ($sections);
                        while (list ($section, $sarray) = each ($sections)) {
                                if (isset($HTTP_POST_VARS['auserchange_section_' . $section])) {
                                        $author[$authoff]['sections'][$section] = $section;
                                } else unset ($author[$authoff]['sections'][$section]);
                        }

                        // Don't do that on debug.
                        if ((!$debug) && ($show != "error")) {
                                setuserarray ($author);
                                $show = "menu";
                        }
                }
        } else {
                $show = "error";
        }
}

</script><script language="php">
// === do: auserkill ===
// === ============= === (admin only)
if ($do == "auserkill") {
        if ($user_admin) {
                $greenlight = 0;
                if ($HTTP_POST_VARS["auserkill_yes"]) {
                        $greenlight = 1;
                } else  if ($HTTP_POST_VARS["auserkill_no"]) {
                        $greenlight = 0;
                        $show = "menu";
                } else {
                        $show = "error";
                }

                if (!$HTTP_GET_VARS["who"]) {
                        $show = "error";
                        $greenlight = 0;
                }

                $fp = fopen ("cgi-bin/" . $username . ".ukon", "r");
                if (!$fp) $show = "error";
                else {
                        $who = trim(fgets($fp, 65535));
                        if (!$who) {
                                $show = "error";
                                $greenlight = 0;
                        } else {
                                if ($who != $HTTP_GET_VARS["who"]) {
                                        $show = "error";
                                        $greenlight = 0;
                                }
                        }
                        fclose ($fp);
                }

                if ($greenlight) {
                        $authoff = -1;
                        for ($i = 0; $i < $authcount; $i++) {
                                if ($who == $author[$i]["name"]) {
                                        $authoff = $i;
                                        break;
                                }
                        }

                        if ($author[$authoff]["admin"]) {
                                $show = "error";
                                $authoff = -1;
                        }

                        unset ($author[$authoff]);

                        // Don't do that on debug.
                        if ((!$debug) && ($show != "error")) {
                                setuserarray ($author);
                                $show = "menu";
                        }
                }
        } else {
                $show = "error";
        }
}

</script><script language="php">
// === do: sendtemplates ===
// === ================= === (admin only)

if ($do == "sendtemplates") {
        if ($user_admin) {
                define ("MAX_UPLOAD_SIZE", 16384);

                $file1 = $HTTP_POST_FILES["templatenews"]["tmp_name"];
                $file1_size = $HTTP_POST_FILES["templatenews"]["size"];
                $file2 = $file["templatenews"];
                if ($file1_size <= MAX_UPLOAD_SIZE) {
                        copy ($file2, $file2 . ".backup");
                        move_uploaded_file ($file1, $file2);
                }

                $file1 = $HTTP_POST_FILES["templatenewshl"]["tmp_name"];
                $file1_size = $HTTP_POST_FILES["templatenewshl"]["size"];
                $file2 = $file["templatenewshl"];
                if ($file1_size <= MAX_UPLOAD_SIZE) {
                        copy ($file2, $file2 . ".backup");
                        move_uploaded_file ($file1, $file2);
                }

                $file1 = $HTTP_POST_FILES["templatearch"]["tmp_name"];
                $file1_size = $HTTP_POST_FILES["templatearch"]["size"];
                $file2 = $file["templatearch"];
                if ($file1_size <= MAX_UPLOAD_SIZE) {
                        copy ($file2, $file2 . ".backup");
                        move_uploaded_file ($file1, $file2);
                }

                $file1 = $HTTP_POST_FILES["templatearchhl"]["tmp_name"];
                $file1_size = $HTTP_POST_FILES["templatearchhl"]["size"];
                $file2 = $file["templatearchhl"];
                if ($file1_size <= MAX_UPLOAD_SIZE) {
                        copy ($file2, $file2 . ".backup");
                        move_uploaded_file ($file1, $file2);
                }

                $show = "ultimate";
        } else {
                $show = "error";
        }
}

</script><script language="php">
// === routine: verbose debug ===
// === ====================== ===

if ($debug) {
        echo "<br>\n";
        echo "Action done '<strong>" . $do . "</strong>' -- show '<strong>" . $show . "</strong>'<br>\n";
        echo "<hr>\n";
}

// === routine: redirection ===
// === ==================== ===

if (($show_a[$show] == 2) && ($HTTP_GET_VARS["show"] != $show)) {
        $do = "redirect";
        $redirectto = $PHP_SELF . "?show=" . $show;
}

if ($do == "redirect" && $redirectto) {
        while (substr ($redirectto, 0, 2) == "//") {
                $redirectto = substr ($redirectto, 1);
        }

        $redirectto = /* "http://" . $HTTP_HOST . */ trim ($redirectto);
        if (!$debug) {
                header ("HTTP/1.0 303 See Other");
                header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                header ("Cache-Control: no-cache, must-revalidate");
                header ("Pragma: no-cache");
                header ("Location: " . $redirectto);
        }
        echo "<html>If you are not redirected automatically then click <a href=\"$redirectto\">here</a>.<br>\n</html>";
        return;
}

</script><script language="php">
// === show: login ===
// === =========== ===

if ($show == "login") {
        $contents = gettemplate($file['managertemplatedir'] . "mlogin.html");

        $contents = str_replace ("%USERNAME%", "", $contents);
        $contents = str_replace ("%PASSWORD%", "", $contents);
}

</script><script language="php">
// === show: menu ===
// === ========== ===

if ($show == "menu") {
        $contents = gettemplate($file['managertemplatedir'] . "mmenu.html");

        $mbuf .= "<strong>" . $language['newsman_sectionmanage'] . ":</strong><br>";
        $mbuf .= '<table border="0" cellspacing="3" cellpadding="0">';
        reset ($sections);
        while (list ($section, $sarray) = each ($sections)) {
                if ((!$user_admin) && (empty($user['sections'][$section]))) continue;
                $mbuf .= '<tr><td align="right" valign="top">' . $sarray['name'] . ' - </td><td valign="top">';
                $mbuf .= "<a href=\"" . $PHP_SELF . "?show=postnews&section=" . $section . "\">add</a> | ";
                $mbuf .= "<a href=\"" . $PHP_SELF . "?show=posteditlist&section=" . $section . "\">edit</a> | ";
                $mbuf .= "<a href=\"" . $PHP_SELF . "?show=postkilllist&section=" . $section . "\">delete</a></td></tr>";
        }
        $mbuf .= '</table><br>';

        $mbuf .= "<a href=\"" . $PHP_SELF . "?show=userchange\">" . $language['newsman_userchange'] . "</a>.<br>" .
                 "<br>\n";

        if ($user_admin) {
                $mbuf .= "<strong>" . $language['newsman_admin'] . ".</strong><br>\n";
                $mbuf .= "<a href=\"" . $PHP_SELF . "?show=auseradd\">" . $language['newsman_auseradd'] . "</a>.<br>\n";
                $mbuf .= "<a href=\"" . $PHP_SELF . "?show=auserchangelist\">" . $language['newsman_auserchange'] . "</a>.<br>\n";
                $mbuf .= "<a href=\"" . $PHP_SELF . "?show=auserkilllist\">" . $language['newsman_auserkill'] . "</a>.<br><br>\n";
                $mbuf .= "<a href=\"" . $PHP_SELF . "?show=sendtemplates\">" . $language['newsman_sendtemplates'] . "</a>.<br>\n";
                $mbuf .= "<a href=\"" . $PHP_SELF . "?show=scriptconfig\">" . $language['newsman_scriptconfig'] . "</a>. (not implemented yet)<br><br>\n";
        }
        $mbuf .= "<a href=\"" . $PHP_SELF . "?action=logout\">" . $language['newsman_logout'] . "</a>.<br>" .
                 "<br>\n";

        $contents = str_replace ("%MENU%", $mbuf, $contents);
}

</script><script language="php">
// === show: postnews ===
// === ============== ===

if ($show == "postnews") {
        $section = $settings['news_defaultsection'];
        if (isset($HTTP_GET_VARS['section'])) {
                $_tempsection = strtolower($HTTP_GET_VARS['section']);
                if (isset($sections[$_tempsection])) {
                        $section = $_tempsection;
                }
                unset ($_tempsection);
        }
        if (empty($user['sections'][$section]) && (!$user_admin)) $show = "error";

        if ($show != "error") {
                $contents = gettemplate($file['managertemplatedir'] . "mpostn.html");

                // %READONLYI% and %READONLYB%
                if (!$user_admin) {
                        $contents = str_replace ("%READONLYI%", "readonly", $contents);
                        $contents = str_replace ("%READONLYB%", "border-bottom: medium none", $contents);
                } else {
                        $contents = str_replace ("%READONLYI%", "", $contents);
                        $contents = str_replace ("%READONLYB%", "border-bottom: 1px solid rgb(0,0,0)", $contents);
                }
                $contents = str_replace ("%DEFAULTSUBJ%", $language["newsman_defaultsubj"], $contents);

                $hlr["time"] = gmdate ("Ymd-H:i", time() + $secoffset);
                $hlr["date"] = substr ($hlr["time"], 0, 6);
                $hlr["time"] = substr ($hlr["time"], 6);

                $hlr["subj"] = '<span id="PreviewSubj">' . $language["newsman_defaultsubj"] . '</span>';
                $hlr["body"] = '<span id="PreviewBody">' . '<strong><big>[fastPreview will update newspost body here]</big></strong>' . '</span>';
                $hlr["from"] = $username;

                $filename = $file["template_" . $section . "hl"];

                $fp = fopen ($filename, "r");
                $template = fread ($fp, filesize ($filename));
                fclose ($fp);

                $hlcls = parsehl($hlr, $author, $authcount);
                $hlcls->html = $template;
                $hlcls = parsetpl($hlcls);

                $contents = str_replace ("%PREVIEW%", $hlcls->html, $contents);
        }
}

</script><script language="php">
// === show: postnewspreview ===
// === ===================== ===

if ($show == "postnewspreview") {
        $section = $settings['news_defaultsection'];
        if (isset($HTTP_GET_VARS['section'])) {
                $_tempsection = strtolower($HTTP_GET_VARS['section']);
                if (isset($sections[$_tempsection])) {
                        $section = $_tempsection;
                }
                unset ($_tempsection);
        }
        if (empty($user['sections'][$section]) && (!$user_admin)) $show = "error";

        if ($show != "error") {
                $contents = gettemplate($file['managertemplatedir'] . "mpostnpreview.html");

                $contents = str_replace ("%SUBJ%", htmlspecialchars($pn_subject), $contents);
                $contents = str_replace ("%SUBJECT%", htmlspecialchars($pn_subject), $contents);
                $contents = str_replace ("%POSTTIME%", $pn_time, $contents);
                $contents = str_replace ("%AUTHOR%", $pn_from, $contents);
                $contents = str_replace ("%BODY%", $pn_body, $contents);
                $contents = str_replace ("%NL2BR%", (string)$pn_nl2br, $contents);

                if (!$user_admin) {
                        $contents = str_replace ("%READONLYI%", "readonly", $contents);
                        $contents = str_replace ("%READONLYB%", "border-bottom: medium none", $contents);
                } else {
                        $contents = str_replace ("%READONLYI%", "", $contents);
                        $contents = str_replace ("%READONLYB%", "border-bottom: 1px solid rgb(0,0,0)", $contents);
                }

                $headline["date"] = substr ($pn_time, 0, 6);
                $headline["time"] = substr ($pn_time, 6);
                $headline["from"] = $pn_from;
                if ($pn_nl2br) {
                        $pn_body = nl2br ($pn_body);
                }

                $pn_body = MakeBodyPretty ($pn_body);
                $headline["subj"] = '<span id="PreviewSubj">' . $pn_subject . '</span>';
                $headline["body"] = '<span id="PreviewBody">' . $pn_body . '</span>';

                $filename = $file["template_" . $section . "hl"];

                $fp = fopen ($filename, "r");
                $template = fread ($fp, filesize ($filename));
                fclose ($fp);

                $hlcls = parsehl($headline, $author, $authcount);
                $hlcls->html = $template;
                $hlcls = parsetpl($hlcls);

                $contents = str_replace ("%PREVIEW%", $hlcls->html, $contents);
        }
}

</script><script language="php">
// === show: posteditlist ===
// === ================== ===

if ($show == "posteditlist") {
        $section = $settings['news_defaultsection'];
        if (isset($HTTP_GET_VARS['section'])) {
                $_tempsection = strtolower($HTTP_GET_VARS['section']);
                if (isset($sections[$_tempsection])) {
                        $section = $_tempsection;
                }
                unset ($_tempsection);
        }
        if (empty($user['sections'][$section]) && (!$user_admin)) $show = "error";

        if ($show != "error") {
                // Make sure we have latest base files.
                $calledfromphp = 1;

                $hlcount = 0;
                $hlidlist = "";
                $headline = qget_headlines();   //QUickly SEt HEadLInes

                reset ($headline);
                while (list ($key, $val) = each ($headline)) {
                        if (isset ($headline[$key]["time"])) {
                                $hlcount++;
                        }
                }

                $tempcount = 0;
                $contents = "<h3 align=\"center\" style=\"margin-top: 0px; margin-bottom: 0px\">" . $language['newsman_posteditlist'] . ":</h3>\n";
                $contents .= "<hr size=\"0\" style=\"margin-top: 0px; margin-bottom: 0px\">\n";
                for ($i = 0; $i < $hlcount; $i++) {
                        if (isset($headline[$i]['section']) && ($headline[$i]['section'] != $section)) continue;
                        if ($user_admin) {
                                $tempbody = strip_tags ($headline[$i]["body"]);
                                $contents .= "<span style=\"float: right\">";
                                if (strlen ($tempbody) < 40)
                                        $contents .= $tempbody;
                                else {
                                        $contents .= substr ($tempbody, 0, 37) . "...";
                                }
                                $contents .= "</span>";

                                $contents .= "<a href=\"%25PHP_SELF%25?show=postedit&id=" . $headline[$i]["idid"] . "&section=" . $section . "\">";
                                $contents .= $headline[$i]["time"] . " ";
                                $contents .= $headline[$i]["from"] . " - ";
                                $contents .= $headline[$i]["subj"] . "</a><br>\n";
                                $tempcount++;
                        } else if (($headline[$i]["from"] == $username) || ($debug)) {
                                $tempbody = strip_tags ($headline[$i]["body"]);
                                $contents .= "<span style=\"float: right\">";
                                if (strlen ($tempbody) < 40)
                                        $contents .= $tempbody;
                                else {
                                        $contents .= substr ($tempbody, 0, 37) . "...";
                                }
                                $contents .= "</span>";

                                $contents .= "<a href=\"%25PHP_SELF%25?show=postedit&id=" . $headline[$i]["idid"] . "&section=" . $section . "\">";
                                $contents .= $headline[$i]["time"] . " - ";
                                $contents .= $headline[$i]["subj"] . "</a><br>\n";
                                $tempcount++;
                        }
                }

                if (!$tempcount)        $contents .= "<center><h2>Sorry, but there are no headlines available for you to edit.</h2></center>\n";
                $contents .= "<hr size=\"0\" style=\"margin-top: 0px; margin-bottom: 0px\">\n";
                $contents .= "<p><a href=\"javascript:history.back()\">Go back</a></p>\n";
        }
}

</script><script language="php">
// === show: postedit ===
// === ============== ===

if (($show == "postedit") && isset($HTTP_GET_VARS["id"])) {
        $section = $settings['news_defaultsection'];
        if (isset($HTTP_GET_VARS['section'])) {
                $_tempsection = strtolower($HTTP_GET_VARS['section']);
                if (isset($sections[$_tempsection])) {
                        $section = $_tempsection;
                }
                unset ($_tempsection);
        }
        if (empty($user['sections'][$section]) && (!$user_admin)) $show = "error";

        if ($show != "error") {
                $contents = gettemplate($file['managertemplatedir'] . "mposte.html");

                $hlcount = 0;
                $hlidlist = "";
                $headline = qget_headlines();   //QUickly SEt HEadLInes

                reset ($headline);
                while (list ($key, $val) = each ($headline)) {
                        if (isset ($headline[$key]["time"])) {
                                $hlcount++;
                        }
                }


                for ($i = 0; $i < $hlcount; $i++) {
                        if ($headline[$i]["idid"] == $HTTP_GET_VARS["id"]) {
                                $postindex = $i;
                                $postid = $headline[$i]["idid"];
                                break;
                        }
                }

                if (($postid) && (!$user_admin) && (!$debug)) {
                        if ($username != $headline[$postindex]["from"]) {
                                $show = "error";
                                $postid = 0;
                                unset ($postindex);
                        }
                }

                if ($postid) {
                        $fp = fopen ("cgi-bin/" . $username . ".peid", "w");
                        if (!$fp) {
                                $show = "error";
                                $postid = 0;
                                unset ($postindex);
                        } else {
                                settype ($peid, "integer");
                                fputs ($fp, $postid);
                                fclose ($fp);
                        }
                }

                if ($postid) {
                        $hlr = $headline[$postindex];

                        $contents = str_replace ("%ID%", $postid, $contents);
                        $contents = str_replace ("%IDID%", $postid, $contents);
                        $contents = str_replace ("%AUTHOR%", $hlr["from"], $contents);
                        $contents = str_replace ("%SUBJ%", htmlspecialchars($hlr["subj"]), $contents);
                        $contents = str_replace ("%SUBJECT%", htmlspecialchars($hlr["subj"]), $contents);
                        $contents = str_replace ("%POSTTIME%", $hlr["time"], $contents);

                        $contents = str_replace ("%NL2BR%", "checked", $contents);
                        $contents = str_replace ("%BODY%", makebodyeditable ($hlr["body"]), $contents);


                        // %READONLYI% and %READONLYB%
                        if (!$user_admin) {
                                $contents = str_replace ("%READONLYI%", "readonly", $contents);
                                $contents = str_replace ("%READONLYB%", "border-bottom: medium none", $contents);
                        } else {
                                $contents = str_replace ("%READONLYI%", "", $contents);
                                $contents = str_replace ("%READONLYB%", "border-bottom: 1px solid rgb(0,0,0)", $contents);
                        }

                        $hlr["date"] = substr ($hlr["time"], 0, 6);
                        $hlr["time"] = substr ($hlr["time"], 6);

                        $hlr["subj"] = '<span id="PreviewSubj">' . $hlr["subj"] . '</span>';
                        $hlr["body"] = '<span id="PreviewBody">' . $hlr["body"] . '</span>';

                        $filename = $file["template_" . $section . "hl"];

                        $fp = fopen ($filename, "r");
                        $template = fread ($fp, filesize ($filename));
                        fclose ($fp);

                        $hlcls = parsehl($hlr, $author, $authcount);
                        $hlcls->html = $template;
                        $hlcls = parsetpl($hlcls);

                        $contents = str_replace ("%PREVIEW%", $hlcls->html, $contents);
                } else {
                        $show = "error";
                }
        }
} else if (($show == "postedit") && empty($HTTP_GET_VARS["id"])) {
        $show = "error";
} else {
}

</script><script language="php">
// === show: posteditpreview ===
// === ===================== ===

if ($show == "posteditpreview") {
        $section = $settings['news_defaultsection'];
        if (isset($HTTP_GET_VARS['section'])) {
                $_tempsection = strtolower($HTTP_GET_VARS['section']);
                if (isset($sections[$_tempsection])) {
                        $section = $_tempsection;
                }
                unset ($_tempsection);
        }
        if (empty($user['sections'][$section]) && (!$user_admin)) $show = "error";

        if ($show != "error") {
                $contents = gettemplate($file['managertemplatedir'] . "mpostepreview.html");

                $hlcount = 0;
                $hlidlist = "";
                $headline = qget_headlines();   //QUickly SEt HEadLInes

                reset ($headline);
                while (list ($key, $val) = each ($headline)) {
                        if (isset ($headline[$key]["time"])) {
                                $hlcount++;
                        }
                }
                $postid = $pe_idid;

                for ($i = 0; $i < $hlcount; $i++) {
                        if ($headline[$i]["idid"] == $pe_idid) {
                                $postindex = $i;
                                $postid = $headline[$i]["idid"];
                                break;
                        }
                }

                if (($postid) && (!$user_admin) && (!$debug)) {
                        if ($username != $headline[$postindex]["from"]) {
                                $show = "error";
                                $postid = 0;
                                unset ($postindex);
                        }
                }

                if ($postid) {
                        $fp = fopen ("cgi-bin/" . $username . ".peid", "w");
                        if (!$fp) {
                                $show = "error";
                                $postid = 0;
                                unset ($postindex);
                        } else {
                                settype ($peid, "integer");
                                fputs ($fp, $postid);
                                fclose ($fp);
                        }
                }

                if ($postid) {
                        $hlr;

                        $contents = str_replace ("%ID%", $postid, $contents);
                        $contents = str_replace ("%IDID%", $postid, $contents);
                        $contents = str_replace ("%AUTHOR%", $pe_from, $contents);
                        $contents = str_replace ("%SUBJ%", htmlspecialchars($pe_subject), $contents);
                        $contents = str_replace ("%SUBJECT%", htmlspecialchars($pe_subject), $contents);
                        $contents = str_replace ("%POSTTIME%", $pe_time, $contents);

                        $body = $pe_body;

                        $contents = str_replace ("%NL2BR%", (string)$pe_nl2br, $contents);
                        $contents = str_replace ("%BODY%", $body, $contents);

                        // %READONLYI% and %READONLYB%
                        if (!$user_admin) {
                                $contents = str_replace ("%READONLYI%", "readonly", $contents);
                                $contents = str_replace ("%READONLYB%", "border-bottom: medium none", $contents);
                        } else {
                                $contents = str_replace ("%READONLYI%", "", $contents);
                                $contents = str_replace ("%READONLYB%", "border-bottom: 1px solid rgb(0,0,0)", $contents);
                        }

                        $hlr["date"] = substr ($pe_time, 0, 6);
                        $hlr["time"] = substr ($pe_time, 6);
                        $hlr["from"] = $pe_from;
                        $hlr["idid"] = $pe_idid;
                        if ($pe_nl2br) {
                                $pe_body = nl2br ($pe_body);
                        }

                        $pe_body = MakeBodyPretty ($pe_body);

                        $hlr["subj"] = '<span id="PreviewSubj">' . $pe_subject . '</span>';
                        $hlr["body"] = '<span id="PreviewBody">' . $pe_body . '</span>';

                        $filename = $file["template_" . $section . "hl"];

                        $fp = fopen ($filename, "r");
                        $template = fread ($fp, filesize ($filename));
                        fclose ($fp);

                        $hlcls = parsehl($hlr, $author, $authcount);
                        $hlcls->html = $template;
                        $hlcls = parsetpl($hlcls);

                        $contents = str_replace ("%PREVIEW%", $hlcls->html, $contents);
                } else {
                        $show = "error";
                }
        }
}

</script><script language="php">
// === show: postkilllist ===
// === ================== ===

if ($show == "postkilllist") {
        $section = $settings['news_defaultsection'];
        if (isset($HTTP_GET_VARS['section'])) {
                $_tempsection = strtolower($HTTP_GET_VARS['section']);
                if (isset($sections[$_tempsection])) {
                        $section = $_tempsection;
                }
                unset ($_tempsection);
        }
        if (empty($user['sections'][$section]) && (!$user_admin)) $show = "error";

        if ($show != "error") {
                // Make sure we have latest base files.
                $calledfromphp = 1;

                $hlcount = 0;
                $hlidlist = "";
                $headline = qget_headlines();   //QUickly SEt HEadLInes

                reset ($headline);
                while (list ($key, $val) = each ($headline)) {
                        if (isset ($headline[$key]["time"])) {
                                $hlcount++;
                        }
                }

                $tempcount = 0;
                $contents = "<h3 align=\"center\" style=\"margin-top: 0px; margin-bottom: 0px\">" . $language['newsman_postkilllist'] . ":</h3>\n";
                $contents .= "<hr size=\"0\" style=\"margin-top: 0px; margin-bottom: 0px\">\n";
                for ($i = 0; $i < $hlcount; $i++) {
                        if (isset($headline[$i]['section']) && ($headline[$i]['section'] != $section)) continue;
                        if ($user_admin) {
                                $tempbody = strip_tags ($headline[$i]["body"]);
                                $contents .= "<span style=\"float: right\">";
                                if (strlen ($tempbody) < 40)
                                        $contents .= $tempbody;
                                else {
                                        $contents .= substr ($tempbody, 0, 37) . "...";
                                }
                                $contents .= "</span>";

                                $contents .= "<a href=\"%25PHP_SELF%25?show=postkill&id=" . $headline[$i]["idid"] . "&section=" . $section . "\">";
                                $contents .= $headline[$i]["time"] . " ";
                                $contents .= $headline[$i]["from"] . " - ";
                                $contents .= $headline[$i]["subj"] . "</a><br>\n";
                                $tempcount++;
                        } else if (($headline[$i]["from"] == $username) || ($debug)) {
                                $tempbody = strip_tags ($headline[$i]["body"]);
                                $contents .= "<span style=\"float: right\">";
                                if (strlen ($tempbody) < 40)
                                        $contents .= $tempbody;
                                else {
                                        $contents .= substr ($tempbody, 0, 37) . "...";
                                }
                                $contents .= "</span>";

                                $contents .= "<a href=\"%25PHP_SELF%25?show=postkill&id=" . $headline[$i]["idid"] . "&section=" . $section . "\">";
                                $contents .= $headline[$i]["time"] . " - ";
                                $contents .= $headline[$i]["subj"] . "</a><br>\n";
                                $tempcount++;
                        }
                }
                if (!$tempcount)        $contents .= "<center>Sorry, but there are no headlines available for you to delete.</center>\n";
                $contents .= "<hr size=\"0\" style=\"margin-top: 0px; margin-bottom: 0px\">\n";
                $contents .= "<p><a href=\"javascript:history.back()\">Go back</a></p>\n";
        }
}

</script><script language="php">
// === show: postkill ===
// === ============== ===

if (($show == "postkill") && isset($HTTP_GET_VARS["id"])) {
        $section = $settings['news_defaultsection'];
        if (isset($HTTP_GET_VARS['section'])) {
                $_tempsection = strtolower($HTTP_GET_VARS['section']);
                if (isset($sections[$_tempsection])) {
                        $section = $_tempsection;
                }
                unset ($_tempsection);
        }
        if (empty($user['sections'][$section]) && (!$user_admin)) $show = "error";

        if ($show != "error") {
                $contents = gettemplate($file['managertemplatedir'] . "mpostkill.html");

                $hlcount = 0;
                $hlidlist = "";
                $headline = qget_headlines();   //QUickly SEt HEadLInes

                reset ($headline);
                while (list ($key, $val) = each ($headline)) {
                        if (isset ($headline[$key]["time"])) {
                                $hlcount++;
                        }
                }

                for ($i = 0; $i < $hlcount; $i++) {
                        if ($headline[$i]["idid"] == $HTTP_GET_VARS["id"]) {
                                $postindex = $i;
                                $postid = $headline[$i]["idid"];
                                break;
                        }
                }

                if (($postid) && (!$user_admin) && (!$debug)) {
                        if ($username != $headline[$postindex]["from"]) {
                                $show = "error";
                                $postid = 0;
                                unset ($postindex);
                        }
                }

                if ($postid) {
                        $hlr = $headline[$postindex];

                        $contents = str_replace ("%ID%", $hlr["idid"], $contents);
                        $contents = str_replace ("%IDID%", $hlr["idid"], $contents);
                        $contents = str_replace ("%AUTHOR%", $hlr["from"], $contents);
                        $contents = str_replace ("%SUBJ%", htmlspecialchars($hlr["subj"]), $contents);
                        $contents = str_replace ("%SUBJECT%", htmlspecialchars($hlr["subj"]), $contents);
                        $contents = str_replace ("%POSTTIME%", $hlr["time"], $contents);

                        $filename = $file["template_" . $section . "hl"];

                        $fp = fopen ($filename, "r");
                        $template = fread ($fp, filesize ($filename));
                        fclose ($fp);

                        $hlr["date"] = substr ($hlr["time"], 0, 6);
                        $hlr["time"] = substr ($hlr["time"], 6);
                        $hlcls = parsehl($hlr, $author, $authcount);
                        $hlcls->html = $template;
                        $hlcls = parsetpl($hlcls);
                        $contents = str_replace ("%PREVIEW%", $hlcls->html, $contents);
                } else {
                        $show = "error";
                }
        }
} else if (($show == "postkill") && empty($HTTP_GET_VARS["id"])) {
        $show = "error";
} else {
}

</script><script language="php">
// === show: userchange ===
// === ================ ===

if ($show == "userchange") {
        $contents = gettemplate($file['managertemplatedir'] . "muserchange.html");
        if ($user_nomail) {
                $contents = str_replace ("%USERNOMAIL%", "checked", $contents);
        } else {
                $contents = str_replace ("%USERNOMAIL%", "", $contents);
        }
}

</script><script language="php">
// === show: auseradd ===
// === ============== === (admin only)

if ($show == "auseradd") {
        if ($user_admin) {
                $contents = gettemplate($file['managertemplatedir'] . "mauseradd.html");
                $_userperms = "";
                while (list ($section, $sarray) = each ($sections)) {
                        $_userperms .= '<input type="checkbox" name="' . $show . '_section_' . $section . '" value="allow">' . $sarray['name'] . '<br>';
                }
                $contents = str_replace ("%SECTIONS%", $_userperms, $contents);
                unset ($_userperms);
        } else {
                $show = "error";
        }
}

</script><script language="php">
// === show: auserchangelist ===
// ============================= (admin only)

if ($show == "auserchangelist") {
        if ($user_admin) {
                $contents = "<h3 align=\"center\" style=\"margin-top: 0px; margin-bottom: 0px\">" . $language['newsman_auserchangelist'] . ":</h3>\n";
                $contents .= "<hr size=\"0\" style=\"margin-top: 0px; margin-bottom: 0px\">\n";
                $count = 0;
                while (list ($key, $val) = each ($author)) {
                        if (!$val["name"]) continue;
                        if ($val["admin"]) continue;
                        $contents .= "<a href=\"%25PHP_SELF%25?show=auserchange&who=" . $val["name"] . "\">";
                        $contents .= $val["name"];
                        $contents .= "</a><br>";
                        $count++;
                }
                if ($count = 0) {
                        $contents .= "<h3>No users found to modify</h3>";
                }
                $contents .= "<hr size=\"0\" style=\"margin-top: 0px; margin-bottom: 0px\">\n";
                $contents .= "<p><a href=\"javascript:history.back()\">Go back</a></p>\n";
        } else {
                $show = "error";
        }
}


// === show: auserchange ===
// === ================= === (admin only)

if ($show == "auserchange") {
        if ($user_admin) {
                unset ($auser);
                while (list ($key, $val) = each ($author)) {
                        if ($val["admin"]) continue;
                        if ($val["name"] == $HTTP_GET_VARS["who"]) $auser = $val;
                }
                if ($auser) {
                        $fp = fopen ("cgi-bin/" . $username . ".ucon", "w");
                        if (!$fp) {
                                $show = "error";
                                unset ($auser);
                        } else {
                                fputs ($fp, $auser["name"]);
                                fclose ($fp);
                        }
                }
                if ($auser) {
                        $contents = gettemplate($file['managertemplatedir'] . "mauserchange.html");

                        if ($auser["nomail"]) $contents = str_replace ("%USERNOMAIL%", "checked", $contents);
                        else $contents = str_replace ("%USERNOMAIL%", "", $contents);

                        $contents = str_replace ("%USERNAME%", $auser["name"], $contents);
                        $contents = str_replace ("%USERMAIL%", $auser["mail"], $contents);
                        $contents = str_replace ("%USERPASS%", $auser["pass"], $contents);

                        $_userperms = "";
                        while (list ($section, $sarray) = each ($sections)) {
                                if (in_array ($section, $auser['sections'])) {
                                        $_userperms .= '<input type="checkbox" name="' . $show . '_section_' . $section . '" value="allow" checked>' . $sarray['name'] . '<br>';
                                } else {
                                        $_userperms .= '<input type="checkbox" name="' . $show . '_section_' . $section . '" value="allow">' . $sarray['name'] . '<br>';
                                }
                        }
                        $contents = str_replace ("%SECTIONS%", $_userperms, $contents);
                        unset ($_userperms);
                } else {
                        $show = "error";
                }
        } else {
                $show = "error";
        }
}

</script><script language="php">
// === show: auserkilllist ===
// ============================= (admin only)

if ($show == "auserkilllist") {
        if ($user_admin) {
                $contents = "<h3 align=\"center\" style=\"margin-top: 0px; margin-bottom: 0px\">" . $language['newsman_auserkilllist'] . ":</h3>\n";
                $contents .= "<hr size=\"0\" style=\"margin-top: 0px; margin-bottom: 0px\">\n";
                $count = 0;
                while (list ($key, $val) = each ($author)) {
                        if (!$val["name"]) continue;
                        if ($val["admin"]) continue;
                        $contents .= "<a href=\"%25PHP_SELF%25?show=auserkill&who=" . $val["name"] . "\">";
                        $contents .= $val["name"];
                        $contents .= "</a><br>";
                        $count++;
                }
                if ($count = 0) {
                        $contents .= "<h3>No users found to remove</h3>";
                }
                $contents .= "<hr size=\"0\" style=\"margin-top: 0px; margin-bottom: 0px\">\n";
                $contents .= "<p><a href=\"javascript:history.back()\">Go back</a></p>\n";
        } else {
                $show = "error";
        }
}


// === show: auserkill ===
// === ================= === (admin only)

if ($show == "auserkill") {
        if ($user_admin) {
                unset ($auser);
                while (list ($key, $val) = each ($author)) {
                        if ($val["admin"]) continue;
                        if ($val["name"] == $HTTP_GET_VARS["who"]) $auser = $val;
                }
                if ($auser) {
                        $fp = fopen ("cgi-bin/" . $username . ".ukon", "w");
                        if (!$fp) {
                                $show = "error";
                                unset ($auser);
                        } else {
                                fputs ($fp, $auser["name"]);
                                fclose ($fp);
                        }
                }
                if ($auser) {
                        $contents = gettemplate($file['managertemplatedir'] . "mauserkill.html");

                        if ($auser["nomail"]) $contents = str_replace ("%USERNOMAIL%", "1", $contents);
                        else $contents = str_replace ("%USERNOMAIL%", "0", $contents);

                        $contents = str_replace ("%USERNAME%", $auser["name"], $contents);
                        $contents = str_replace ("%USERMAIL%", $auser["mail"], $contents);
                        $contents = str_replace ("%USERPASS%", $auser["pass"], $contents);
                        $_userperms = "";
                        while (list ($section, $sarray) = each ($sections)) {
                                if (in_array ($section, $auser['sections'])) {
                                        $_userperms .= $sarray['name'] . '<br>';
                                }
                        }
                        $contents = str_replace ("%SECTIONS%", $_userperms, $contents);
                        unset ($_userperms);
                } else {
                        $show = "error";
                }
        } else {
                $show = "error";
        }
}

</script><script language="php">
// === show: sendtemplates ===
// === =================== === (admin only)

if ($show == "sendtemplates") {
        if ($user_admin) {
                $contents = gettemplate($file['managertemplatedir'] . "mauptpl.html");
        } else {
                $show = "error";
        }
}

</script><script language="php">
// === show: error (general error) ===
// === =========== =============== ===

if ($show == "error") {
        header ("HTTP/1.1 412 Precondition Failed");
        $contents = gettemplate($file['managertemplatedir'] . "merror.html");
}

</script><script language="php">
// === show: nocookie (error) ===
// === ============== ======= ===

if ($show == "nocookie") {
        header ("HTTP/1.1 412 Conflict");
        $contents = gettemplate($file['managertemplatedir'] . "mecookie.html");
}

</script><script language="php">
// === show: relogin (error) ===
// === ============= ======= ===

if ($show == "relogin") {
        header ("HTTP/1.1 412 Precondition Failed");
        $contents = gettemplate($file['managertemplatedir'] . "merelogin.html");
}

</script><script language="php">
// === show: repostnews (error) ===
// === ================ ======= ===

if ($show == "repostnews") {
        header ("HTTP/1.1 409 Conflict");
        $contents = gettemplate($file['managertemplatedir'] . "merepostnews.html");
}

</script><script language="php">
// === show: reuc (error) ===
// === ========== ======= ===

if ($show == "reucn") {
        header ("HTTP/1.1 409 Conflict");
        $contents = gettemplate($file['managertemplatedir'] . "mereucn.html");
}

if ($show == "reucp") {
        header ("HTTP/1.1 409 Conflict");
        $contents = gettemplate($file['managertemplatedir'] . "mereucp.html");
}

</script><script language="php">
// === show: ultimate (utility) ===
// === ============== ========= ===

if ($show == "ultimate") {
        $contents = "<html>";
        $contents .= '<meta http-equiv="refresh" content="0; url=%25PHP_SELF%25?show=menu">';
        $contents .= "<body>Processing your request...<br><br>If you're not taken to the main menu automatically then click <a href=\"%25PHP_SELF%25?show=menu\">here</a>.<br></body>";
        $contents .= "</html>";
}

</script><script language="php">
// === routine: macros management ===
// === ========================== ===

if ($show) {
        if (!$notemplate) echo $header . "\n";
        if (isset($contents)) {
                $contents = str_replace ("%25PHP_SELF%25", $PHP_SELF, $contents);
                $contents = str_replace ("%PHP_SELF%", $PHP_SELF, $contents);
                $contents = str_replace ("%USERNAME%", $username, $contents);
                $contents = str_replace ("%USERMAIL%", $usermail, $contents);
                $contents = str_replace ("%CURRENTTIME%", gmdate ("Ymd-H:i", time() + $secoffset), $contents);
                $contents = str_replace ("%SECTION%", $section, $contents);
                echo $contents;
        }
        if (!$notemplate) echo $footer . "\n";
}

// ===================================
if ($debug) {
        phpinfo();
}
ob_end_flush();
return; // Don't process anything below.
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>NewsScript Manager</title>
</head>

<body vlink="#0000FF" alink="#000080">


<p align="center"><strong>Please don't modify this file if you're not sure what you will
cause by modifying it.</strong></p>

<p align="center"><strong>Пожалуйста не редактируйте этот
файл если вы не уверены в последствиях.</strong></p>
</body>
</html>
