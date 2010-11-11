<?php
include "includes/head.php";
?>

<table width="950"  border="0" align="center" cellpadding="10">
  <tr>
    	<td><center>
		
		<?php
		// Check that datadir is populated
		  if (
			file_exists('./datadir/cpu') && 
			file_exists('datadir/memory') && 
			file_exists('./datadir/network') && 
			file_exists('./datadir/swap') && 
			file_exists('./datadir/io') &&
			file_exists('./datadir/load')
		     ) {
			
			if (
			count(file('./datadir/cpu')) >= 2 &&
                        count(file('./datadir/memory')) >= 2 &&
                        count(file('./datadir/network')) >= 2 &&
                        count(file('./datadir/swap')) >= 2 &&
                        count(file('./datadir/io')) >= 2 &&
                        count(file('./datadir/load')) >= 2 
			) {

		?>

		 <a href='history.php?type=cpu'><img border=0 src=graphs/cpu-current.jpg></a>
		 <br>
		 <a href='history.php?type=memory'><img border=0 src=graphs/memory-current.jpg></a>
		 <a href='history.php?type=swap'><img border=0 src=graphs/swap-current.jpg></a>
		 <br>
		 <a href='history.php?type=io'><img border=0 src=graphs/io-current.jpg></a>
		 <a href='history.php?type=load'><img border=0 src=graphs/load-current.jpg></a>
		 <br>
		 <a href='history.php?type=network'><img border=0 src=graphs/network-current.jpg></a>

		<?php

			}else{
		  	echo "<font color='blue' face='Arial, Helvetica, sans-serif'><b>sarGraphs has not yet pulled enough data from sysstat</b></font>";
		        }
		
		  }else{
		  echo "<font color='blue' face='Arial, Helvetica, sans-serif'><b>sarGraphs has not yet graphed your sysstat data.</b></font>";
		  }
		?>
	</center></td>
  </tr>
</table>
<?php
include "includes/footer.php";
?>
