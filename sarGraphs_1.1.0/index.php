<?php
include "includes/head.php";
?>

<table width="950"  border="0" align="center" cellpadding="10">
  <tr>
    	<td><center>
		<a href='history.php?type=cpu'><img border=0 src=graphs/cpu-current.jpg></a>
		 <a href='history.php?type=memory'><img border=0 src=graphs/memory-current.jpg></a>
		 <br>
		 <a href='history.php?type=network'><img border=0 src=graphs/network-current.jpg></a>
		 <br>
		 <a href='history.php?type=swap'><img border=0 src=graphs/swap-current.jpg></a>
		 <a href='history.php?type=io'><img border=0 src=graphs/io-current.jpg></a>
		 <a href='history.php?type=load'><img border=0 src=graphs/load-current.jpg></a>
	</center></td>
  </tr>
</table>
<?php
include "includes/footer.php";
?>
