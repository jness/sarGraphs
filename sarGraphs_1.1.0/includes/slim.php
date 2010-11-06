<html>
<head>
<title>sarGraphs Version 1.1.0</title>
<style type="text/css">
<!--
body {
        margin-left: 0px;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
}

a {
text-decoration: none;
}

h3.trigger {
	padding: 0 0 0 50px;
	margin: 0 0 5px 0;
	height: 46px;
	line-height: 46px;
	width: 550px;
	font-size: .85em;
	float: left;
}
h3.trigger a {
	color: #fff;
	text-decoration: none;
	display: block;
}
h3.trigger a:hover { color: #ccc; }
h3.active {background-position: left bottom;} /*--When toggle is triggered, it will shift the image to the bottom to show its "opened" state--*/
.toggle_container {
	margin: 0 0 5px;
	padding: 0;
	border-top: 1px solid #d6d6d6;
	background: #f0f0f0 url(toggle_block_stretch.gif) repeat-y left top;
	overflow: hidden;
	font-size: .90em;
	width: 900px;
	clear: both;
}
.toggle_container .block {
	padding: 20px; /*--Padding of Container--*/
	background: url(toggle_block_btm.gif) no-repeat left bottom; /*--Bottom rounded corners--*/
}

-->
</style>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
$(document).ready(function(){

	//Hide (Collapse) the toggle containers on load
	$(".toggle_container").hide(); 

	//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
	$("h2.trigger").click(function(){
		$(this).toggleClass("active").next().slideToggle("slow");
		return false; //Prevent the browser jump to the link anchor
	});

});
</script>

</head>

<body onload="init()">
<table width="100%"  border="0" cellpadding="5" cellspacing="0">
  <tr align='right'>
    <td bgcolor="#666666">
	<a href='index.php'><font size='2' color='white' face='Verdana, Arial, Helvetica, sans-serif'><b>HOME</b></font></a>
	<font size='2' color='white' face='Arial, Helvetica, sans-serif'> | </font>
	<a href='logout.php'><font size='2' color='white' face='Verdana, Arial, Helvetica, sans-serif'><b>LOGOUT</b></font></a>
	<font size='2' color='white' face='Arial, Helvetica, sans-serif'> | </font>
	<a href='http://www.gnu.org/licenses/gpl-2.0.txt'><font size='2' color='white' face='Verdana, Arial, Helvetica, sans-serif'><b>LICENSE</b></font></a>
	<font size='2' color='white' face='Arial, Helvetica, sans-serif'> | </font>
	<a href='about.php'><font size='2' color='white' face='Verdana, Arial, Helvetica, sans-serif'><b>ABOUT</b></font></a> 
    </td>
  </tr>
</table>
<table width="950"  border="0" align="center" cellpadding="10">
  <tr>
    <td><center><h1><a href='index.php'><font color='#666666' face='Arial, Helvetica, sans-serif'>sarGraphs</font></a></h1>
        </center>
   </td>
  </tr>

