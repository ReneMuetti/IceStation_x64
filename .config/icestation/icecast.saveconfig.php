<?php
  include ("icecast.functions.php");

  if ($_GET['ices0'] == "on") {
    $ices0 = "1";
  } else {
    $ices0 = "0";
  }
	
  if ($_GET['randomize'] == "on") {
    $randomize = "1";
  } else {
    $randomize = "0";
  }
  
  if ($_GET['public'] == "on") {
    $public = "1";
  } else {
    $public = "0";
  }
  
  if ($_GET['reencode'] == "on") {
    $reencode = "1";
  } else {
    $reencode = "0";
  }
	
  if ($_GET['action'] == "send") {
  $File = "icecast.includes.php"; 
  $Handle = fopen($File, 'w');

  $Data = '<?php
$port = "' . $_GET['port'] .'";
$password = "' . $_GET['password'] .'";

$ices0 = "' . $ices0 .'";
$randomize = "' . $randomize .'";

$name = "' . $_GET['name'] .'";
$genre = "' . $_GET['genre'] .'";
$description = "' . $_GET['description'] .'";
$URL = "' . $_GET['URL'] .'";

$public = "' . $public .'";

$reencode = "' . $reencode .'";
$bitrate = "' . $_GET['bitrate'] .'";
$channels = "' . $_GET['channels'] .'";
?>';
 
  fwrite($Handle, $Data); 
  fclose($Handle); 


  $File = "icecast.ices.conf"; 
  $Handle = fopen($File, 'w');

  $Data = $ices0;
 
  fwrite($Handle, $Data); 
  fclose($Handle); 
  }
  
  generate_configs();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="2;url=index.php">
<title>QNAP IceStation - Saving config file</title>
<style type="text/css">
<!--
body {
	background-color: #666666;
}
body,td,th {
	font-family: Trebuchet MS, Calibri, Arial, Tahoma;
	font-size: 12px;
	color: #FFFFFF;
}
-->
</style>
</head>

<body>
<div align="center">
  <table width="400" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="5" height="5" bgcolor="#333333"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td width="5" height="5" bgcolor="#333333"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td height="5" bgcolor="#333333"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td width="5" height="5" bgcolor="#333333"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td width="5" height="5" bgcolor="#333333"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
    </tr>
    <tr>
      <td width="5" height="5" bgcolor="#333333"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td width="5" height="5"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td height="5"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td width="5" height="5"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td width="5" height="5" bgcolor="#333333"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
    </tr>
    <tr>
      <td width="5" bgcolor="#333333"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td width="5"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td><div align="center">Saving configuration...<br /><br /><font color="#ff3333"><strong>After update, remember to restart IceStation.</strong></font></div></td>
      <td width="5"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td width="5" bgcolor="#333333"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
    </tr>
    <tr>
      <td width="5" height="5" bgcolor="#333333"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td width="5" height="5"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td height="5"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td width="5" height="5"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td width="5" height="5" bgcolor="#333333"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
    </tr>
    <tr>
      <td width="5" height="5" bgcolor="#333333"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td width="5" height="5" bgcolor="#333333"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td height="5" bgcolor="#333333"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td width="5" height="5" bgcolor="#333333"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
      <td width="5" height="5" bgcolor="#333333"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
    </tr>
  </table>
</div>
</body>
</html>
