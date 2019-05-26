<?

/**
 * Displays a table of the workers
 * @author PHP developer
 */

function display_workers()
{
	global $db;

	for ($i=0, $n=count($db); $i<$n; $i++) {
	    $worker_data = $db[$i];
	    $worker_name = $worker_data[0];
	    $worker_address = $worker_data[1];
	    $worker_phone = $worker_data[2];
	    print "<tr bgcolor=\".row_color($i).\">\n";
	    print "<td>$worker_name</td>\n";
	    print "<td>$worker_address</td>\n";
	    print "<td>$worker_phone</td>\n";
	    print "</tr>\n";
	}
}

display_workers();
echo $undedfined_variable;

<<< HeredocExample
example
HeredocExample

?>
