<?

$fp = popen('/test2.exe', 'r+');
print ("$fp   ");
$a = fwrite($fp,"jj\n");
echo $a;
$s = fgets($fp, 20);
  
print("       s  = $s");
pclose($fp);
  exit;


?>