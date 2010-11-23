<?php
include "includes/head.php";
include "includes/banner.php";
?>

<table width="950"  border="0" align="center" cellpadding="10">
  <tr>
    	<td><center>
		
		<?php
		// Check that datadir is populated
		  if (
			file_exists('../scripts/datadir/cpu') && 
			file_exists('../scripts/datadir/memory') && 
			file_exists('../scripts/datadir/network') && 
			file_exists('../scripts/datadir/swap') && 
			file_exists('../scripts/datadir/io') &&
			file_exists('../scripts/datadir/load')
		     ) {
			
			if (
			count(file('../scripts/datadir/cpu')) >= 2 &&
                        count(file('../scripts/datadir/memory')) >= 2 &&
                        count(file('../scripts/datadir/network')) >= 2 &&
                        count(file('../scripts/datadir/swap')) >= 2 &&
                        count(file('../scripts/datadir/io')) >= 2 &&
                        count(file('../scripts/datadir/load')) >= 2 
			) {

		?>

		 <a href='history.php?type=cpu'><img border=0 src=graphs/cpu-current.jpg></a>
		 <br>
		 <a href='history.php?type=memory'><img border=0 src=graphs/memory-current.jpg></a><a href='history.php?type=swap'><img border=0 src=graphs/swap-current.jpg></a>
		 <br>
		 <a href='history.php?type=io'><img border=0 src=graphs/io-current.jpg></a><a href='history.php?type=load'><img border=0 src=graphs/load-current.jpg></a>
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
