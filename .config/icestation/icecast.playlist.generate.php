<?php
  if ($_GET['action'] == "send") {
  $File = "icecast.playlist.includes.php"; 
  $Handle = fopen($File, 'w');

  $Data = '<?php
$path = "' . $_GET['path'] .'";
?>';
 
  fwrite($Handle, $Data); 
  fclose($Handle); 
  }
  
  $File = "/share/Qweb/.config/icestation/icecast.path.conf"; 
  $Handle = fopen($File, 'w');

  $Data = '/share' . $_GET['path'];

  fwrite($Handle, $Data); 
  fclose($Handle); 

  exec("/bin/sh /share/Qweb/.config/icestation/icecast.playlist.generate.sh");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="2;url=index.php">
<title>QNAP IceStation - Saving config file</title>
<style type="text/css">
<!--
img, div, a, input { behavior: url(icecast.images/iepngfix.htc) }
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
      <td><div align="center">Generating playlist...<br /><br /><font color="#ff3333"><strong>After update, remember to restart IceStation.</strong></font></div></td>
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
