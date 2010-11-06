<?php

// Verify GET data was sent
if (!isset($_GET['type'])) {
	header('Location: index.php');
}

// Only allow 6 types of input

if ($_GET['type'] == 'cpu') {
	$type = 'cpu';
}else if ($_GET['type'] == 'memory') {
	$type = 'memory';
}else if ($_GET['type'] == 'io') {
        $type = 'io';
}else if ($_GET['type'] == 'swap') {
        $type = 'swap';
}else if ($_GET['type'] == 'load') {
        $type = 'load';
}else if ($_GET['type'] == 'network') {
        $type = 'network';
}else{
	header('Location: index.php');
}


include "includes/head.php";
?>

<table width="950"  border="0" align="center" cellpadding="10">
  <tr>
    	<td><center>
		<?php

	if ($handle = opendir('./graphs')) {
	    while (false !== ($file = readdir($handle))) {
        	if ($file != "." && $file != "..") {
			$chk = explode("-", $file);
				if ($chk[0] == "$type" && $chk[1] != 'current.jpg') {
				  $year = explode(".", $chk[3]);
				echo "<font color='blue' face='Arial, Helvetica, sans-serif'><b>$chk[1]-$chk[2]-$year[0]</b></font><br>";
		            	echo "<img src=graphs/$file><br>";
				echo '<h2 class="trigger"><a href="#"><font size="1" color="blue" face="Arial, Helvetica, sans-serif">Show/Hide Raw</font></a></h2>';
				echo '<div class="toggle_container">';
				echo '<div class="block">';
				echo '<h5>Raw</h5>';
				echo "<pre>" . `cat ./raw/$type-$chk[1]-$chk[2]-$year[0].txt` . "</pre>";
				echo '</div>';
				echo '</div>';
				}
       		 }
   	    }
    closedir($handle);
}
		
		?>

	</center></td>
  </tr>
</table>
<?php
include "includes/footer.php";
?>
