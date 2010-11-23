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
include "includes/slim_banner.php";
?>
<center><a href='help.php?type=<?php echo $type; ?>'><img alt='More information about this data' border='0' src='images/dialog-information.png'></a></center>
<table width="950"  border="0" align="center" cellpadding="0">
  <tr>
    	<td><center>
		<?php

		if ($handle = opendir('./graphs')) {
		    while (false !== ($file = readdir($handle))) {
		        if ($file != "." && $file != "..") {
		        $file = explode("-", $file);
		            if ($file[0] == "$type" && $file[1] != 'current.jpg') {
				$year = explode(".", $file[3]);
		                $files[]="$file[0]-$file[1]-$file[2]-$file[3]";
		            }
		        }
		    }
		}
		closedir($handle);
		array_multisort(&$files,SORT_DESC);

		foreach ($files as $file) {
		
			$date=explode('.', $file);
			$date=$date[0];
			$timestamp=explode("-",$date);
			$timestamp="$timestamp[1]-$timestamp[2]-$timestamp[3]";

                                echo "<h2 class='trigger'><a href='#'><font color='blue' size='2' face='Arial, Helvetica, sans-serif'><b>$timestamp</b></font> <font size='1' color='blue' face='Arial, Helvetica, sans-serif'>Show/Hide Raw</font></a></h2>";
                                echo '<div class="toggle_container">';
                                echo '<div class="block">';
                                echo "<pre>" . `cat ./raw/$date.txt` . "</pre>";
                                echo '</div></div>';

                                echo "<img src=graphs/$file><br><br>...<br>";

	      } 
?>
	</center></td>
  </tr>
</table>
<?php
include "includes/footer.php";
?>
