<?php

session_start();

if (isset($_SESSION['admin'])) {
header ("Location: index.php");
}

if ($_POST) {
  include 'password_file.php';
  if ($_POST['password'] == $password) {
  $_SESSION['admin'] = 'true';
header ("Location: index.php");

}else{

header ("Location: login.php");
}

}else{
?>

<head>
<title>sarGraphs Version 1.1</title>
<style type="text/css">
body {
        margin-left: 0px;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
}

input.btn { 
	  color:#fff; 
	  font: bold 84% 'trebuchet ms',helvetica,sans-serif; 
	  background-color:#666; 
	  border:1px solid; 
	  border-color: #666 #666 #666 #666; 
}

</style>
</head>
<body>

<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#666666">&nbsp;</td>
  </tr>
</table>
<table width="950"  border="0" align="center" cellpadding="10">
  <tr>
    <td><center><h1><font color='#666666' face='Arial, Helvetica, sans-serif'>sarGraphs</font></h1>
	<font color='#666666' face='Arial, Helvetica, sans-serif'>Please Login:</font>
</td></tr></table>

<center>
<form action="login.php" method="POST">
<input type="password" name="password" />
<input type="submit" value="Submit" class='btn'/>
</form>
</center>
</body>
<?php
}
?>
