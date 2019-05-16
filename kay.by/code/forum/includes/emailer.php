<?php
/***************************************************************************
                                emailer.php
                             -------------------
    begin                : Sunday Aug. 12, 2001
    copyright            : (C) 2001 The phpBB Group
    email                : support@phpbb.com

    $Id: emailer.php,v 1.15.2.6 2002/08/07 22:36:33 dougk_ff7 Exp $

***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

//
// The emailer class has support for attaching files, that isn't implemented
// in the 2.0 release but we can probable find some way of using it in a future
// release
//
class emailer
{
	var $tpl_file;
	var $use_smtp;
	var $msg;
	var $mimeOut;
	var $arrPlaceHolders = array();	// an associative array that has the key = placeHolderName and val = placeHolderValue.
	var $subject, $extra_headers, $address;

	function emailer($use_smtp)
	{
		$this->use_smtp = $use_smtp;
		$this->tpl_file = NULL;
		$this->address = NULL;
 		$this->msg = '';
		$this->mimeOut = '';
	}

	//
	// Resets all the data (address, template file, etc etc to default
	//
	function reset()
	{
		$this->tpl_file = '';
		$this->address = '';
		$this->msg = '';
		$this->memOut = '';
		$this->vars = '';
	}

	//
	// Sets an email address to send to
	//
	function email_address($address)
	{
		$this->address = '';
		$this->address .= $address;
	}

	//
	// set up subject for mail
	//
	function set_subject($subject = '')
	{
		$this->subject = $subject;
	}

	//
	// set up extra mail headers
	//
	function extra_headers($headers)
	{
		$this->extra_headers = $headers;
	}

	function use_template($template_file, $template_lang = '')
	{
		global $board_config, $phpbb_root_path;

		if ( $template_lang == '' )
		{
			$template_lang = $board_config['default_lang'];
		}

		$this->tpl_file = $phpbb_root_path . 'language/lang_' . $template_lang . '/email/' . $template_file . '.tpl';
		if ( !file_exists($this->tpl_file) )
		{
			message_die(GENERAL_ERROR, 'Could not find email template file ' . $template_file, '', __LINE__, __FILE__);
		}

		if ( !$this->load_msg() )
		{
			message_die(GENERAL_ERROR, 'Could not load email template file ' . $template_file, '', __LINE__, __FILE__);
		}

		return true;
	}

	//
	// Open the template file and read in the message
	//
	function load_msg()
	{
		if ( $this->tpl_file == NULL )
		{
			message_die(GENERAL_ERROR, 'No template file set', '', __LINE__, __FILE__);
		}

		if ( !($fd = fopen($this->tpl_file, 'r')) )
		{
			message_die(GENERAL_ERROR, 'Failed opening template file', '', __LINE__, __FILE__);
		}

		$this->msg .= fread($fd, filesize($this->tpl_file));
		fclose($fd);

		return true;
	}

	function assign_vars($vars)
	{
		$this->vars = ( empty($this->vars) ) ? $vars : $this->vars . $vars;
	}

	function parse_email()
	{
		global $lang;
		@reset($this->vars);
		while (list($key, $val) = @each($this->vars))
		{
			$$key = $val;
		}

    	// Escape all quotes, else the eval will fail.
		$this->msg = str_replace ("'", "\'", $this->msg);
		$this->msg = preg_replace('#\{([a-z0-9\-_]*?)\}#is', "' . $\\1 . '", $this->msg);

		eval("\$this->msg = '$this->msg';");

		//
		// We now try and pull a subject from the email body ... if it exists,
		// do this here because the subject may contain a variable
		//
		$match = array();
		preg_match("/^(Subject:(.*?)[\r\n]+?)?(Charset:(.*?)[\r\n]+?)?(.*?)$/is", $this->msg, $match);

		$this->msg = ( isset($match[5]) ) ? trim($match[5]) : '';
		$this->subject = ( $this->subject != '' ) ? $this->subject : trim($match[2]);
		$this->encoding = ( trim($match[4]) != '' ) ? trim($match[4]) : $lang['ENCODING'];

		return true;
	}

	//
	// Send the mail out to the recipients set previously in var $this->address
	//
	function send()
	{
		global $phpEx, $phpbb_root_path;

		if ( $this->address == NULL )
		{
			message_die(GENERAL_ERROR, 'No email address set', '', __LINE__, __FILE__);
		}

		if ( !$this->parse_email() )
		{
			return false;
		}

		//
		// Add date and encoding type
		//
		$universal_extra = "MIME-Version: 1.0\nContent-type: text/plain; charset=" . $this->encoding . "\nContent-transfer-encoding: 8bit\nDate: " . gmdate('D, d M Y H:i:s', time()) . " UT\n";
		$this->extra_headers = $universal_extra . $this->extra_headers; 

		if ( $this->use_smtp )
		{
			if ( !defined('SMTP_INCLUDED') ) 
			{
				include($phpbb_root_path . 'includes/smtp.' . $phpEx);
			}

			$result = smtpmail($this->address, $this->subject, $this->msg, $this->extra_headers);
		}
		else
		{
			$result = @mail($this->address, $this->subject, $this->msg, $this->extra_headers);
		}

		if ( !$result )
		{
			message_die(GENERAL_ERROR, 'Failed sending email', '', __LINE__, __FILE__);
		}

		return true;
	}


	//
	// Attach files via MIME.
	//
	function attachFile($filename, $mimetype = "application/octet-stream", $szFromAddress, $szFilenameToDisplay)
	{
		global $lang;
		$mime_boundary = "--==================_846811060==_";

		$this->mailMsg = '--' . $mime_boundary . "\nContent-Type: text/plain;\n\tcharset=\"" . $lang['ENCODING'] . "\"\n\n" . $this->mailMsg;

		if ($mime_filename)
		{
			$filename = $mime_filename;
			$encoded = $this->encode_file($filename);
		}

		$fd = fopen($filename, "r");
		$contents = fread($fd, filesize($filename));

		$this->mimeOut = "--" . $mime_boundary . "\n";
		$this->mimeOut .= "Content-Type: " . $mimetype . ";\n\tname=\"$szFilenameToDisplay\"\n";
		$this->mimeOut .= "Content-Transfer-Encoding: quoted-printable\n";
		$this->mimeOut .= "Content-Disposition: attachment;\n\tfilename=\"$szFilenameToDisplay\"\n\n";

		if ( $mimetype == "message/rfc822" )
		{
			$this->mimeOut .= "From: ".$szFromAddress."\n";
			$this->mimeOut .= "To: ".$this->emailAddress."\n";
			$this->mimeOut .= "Date: ".date("D, d M Y H:i:s") . " UT\n";
			$this->mimeOut .= "Reply-To:".$szFromAddress."\n";
			$this->mimeOut .= "Subject: ".$this->mailSubject."\n";
			$this->mimeOut .= "X-Mailer: PHP/".phpversion()."\n";
			$this->mimeOut .= "MIME-Version: 1.0\n";
		}

		$this->mimeOut .= $contents."\n";
		$this->mimeOut .= "--" . $mime_boundary . "--" . "\n";

		return $out;
		// added -- to notify email client attachment is done
	}

	function getMimeHeaders($filename, $mime_filename="")
	{
		$mime_boundary = "--==================_846811060==_";

		if ($mime_filename)
		{
			$filename = $mime_filename;
		}

		$out = "MIME-Version: 1.0\n";
		$out .= "Content-Type: multipart/mixed;\n\tboundary=\"$mime_boundary\"\n\n";
		$out .= "This message is in MIME format. Since your mail reader does not understand\n";
		$out .= "this format, some or all of this message may not be legible.";

		return $out;
	}

	//
   // Split string by RFC 2045 semantics (76 chars per line, end with \r\n).
	//
	function myChunkSplit($str)
	{
		$stmp = $str;
		$len = strlen($stmp);
		$out = "";

		while ($len > 0)
		{
			if ($len >= 76)
			{
				$out .= substr($stmp, 0, 76) . "\r\n";
				$stmp = substr($stmp, 76);
				$len = $len - 76;
			}
			else
			{
				$out .= $stmp . "\r\n";
				$stmp = "";
				$len = 0;
			}
		}
		return $out;
	}

	//
   // Split the specified file up into a string and return it
	//
	function encode_file($sourcefile)
	{
		if (is_readable($sourcefile))
		{
			$fd = fopen($sourcefile, "r");
			$contents = fread($fd, filesize($sourcefile));
	      $encoded = $this->myChunkSplit(base64_encode($contents));
	      fclose($fd);
		}

		return $encoded;
	}

} // class emailer

?>
