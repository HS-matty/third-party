<?

function check_login()
	{

if (!defined('IN_SHOP'))	die();
if (session_is_registered("ses_id") && session_is_registered("login") && session_is_registered("user_rights")) 
																							return 'true';
else return 'false';



	}
		

		





?>