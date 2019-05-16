<?
// Mobika Group Ltd / Minsk / Belarus / 2004y

require 'inc/init.php';

$tmpl = new cTemplate('tmpl/index.tmpl',array(
			'enable_eval_errors' => true,
			'disable_warnings' => 1
	));

$phones = array("Alcatel","Motorola","Nokia","Panasonic","Samsung","Siemens","Sony Ericsson");
$ph = array();
for( $i=0; $i<count($phones); $i++ ) {
  $ph[$i]['phone_model_id'] = $i+1;
  $ph[$i]['phone_name'] = $phones[$i];
}

$tmpl->param['phones'] = $ph;

echo $tmpl->parse();

?>