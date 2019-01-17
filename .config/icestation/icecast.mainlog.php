<?php
  include ("icecast.includes.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>QNAP IceStation - Config Management</title>
<style type="text/css">
<!--
img, div, a, input { behavior: url(icecast.images/iepngfix.htc) }
body {
	background-color: #666666;
}
.v11white {
	color: #FFFFFF;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
}
.v10white {
	font-size: 10px;
	color: #FFFFFF;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
input.default {
    width:87px;
	height:16px;
	font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	background-color: #cad1d7;
	color: #1d232b;
	border:none;
}
input.custom {
    width:275px;
	height:16px;
	font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	background-color: #cad1d7;
	color: #1d232b;
	border:none;
}
textarea.log {
    width:830px;
	height:200px;
	font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	background-color: #cad1d7;
	color: #1d232b;
	border:none;
}
input {
	border:none;
}
body,td,th {
	font-family: Trebuchet MS, Calibri, Arial, Tahoma;
	font-size: 12px;
	color: #FFFFFF;
}

a {
	color: #ffffff;
	text-decoration: none;
}
a:link { text-decoration: none; }
a:visited { text-decoration: none; }
a:hover { text-decoration: underline; }
a:unknown { text-decoration: none; }
a:active { text-decoration: none; }
.t12b {color: #1d232b}
-->
</style>
<script type="text/javascript">
<!--
window.onload = init;
function init() {
	MM_preloadImages('icecast.images/menu_button_show_ices_log_focus.png','icecast.images/button_restart_icecast_focus.png','icecast.images/button_save_focus.png','icecast.images/menu_button_show_ices_log_focus.png','icecast.images/button_save_focus.png','icecast.images/button_restart_icecast_focus.png','icecast.images/button_generate_focus.png','icecast.images/button_refresh_focus.png', 'icecast.images/menu_button_configuration_focus.png');
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>

<body>
<div align="center">
  <table width="1000" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><img src="icecast.images/window_top.png" alt="QNAP Ice Station" width="1000" height="122" /></td>
    </tr>
    <tr>
      <td height="30" valign="bottom" background="icecast.images/window_menu_bg.png"><table width="1000" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="85" height="30"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
          <td width="98" valign="bottom"><a href="index.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Button_configuration','','icecast.images/menu_button_configuration_focus.png',1)"><img src="icecast.images/menu_button_configuration.png" alt="Configuration" name="Button_configuration" width="98" height="30" border="0" id="Button_configuration" /></a></td>
          <td width="8"><img src="icecast.images/window_menu_bg_tabsep.png" width="8" height="30" /></td>
          <td width="98" valign="bottom"><a href="icecast.playlists.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Button_playlists','','icecast.images/menu_button_playlists_focus.png',1)"><img src="icecast.images/menu_button_playlists.png" alt="Playlists" name="Button_playlists" width="98" height="30" border="0" id="Button_playlists" /></a></td>
          <td width="8"><img src="icecast.images/window_menu_bg_tabsep.png" width="8" height="30" /></td>
          <td width="98" valign="bottom"><img src="icecast.images/menu_button_show_main_log_selected.png" alt="Show Main Log" width="98" height="30" border="0" /></td>
          <td width="8"><img src="icecast.images/window_menu_bg_tabsep.png" width="8" height="30" /></td>
          <td width="98" valign="bottom"><a href="icecast.log.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Button_ShowLog','','icecast.images/menu_button_show_ices_log_focus.png',1)"><img src="icecast.images/menu_button_show_ices_log.png" alt="Show IceLog" name="Button_ShowLog" width="98" height="30" border="0" id="Button_ShowLog" /></a></td>
          <td><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
          <td width="190" align="center" valign="middle"><span class="v11white"><a href="http://<?php echo $HTTP_SERVER_VARS["HTTP_HOST"]; ?>:<?php echo ("$port"); ?>" target="_blank"><?php echo $HTTP_SERVER_VARS["HTTP_HOST"]; ?>:<?php echo ("$port"); ?></a> &nbsp; <a href="http://<?php echo $HTTP_SERVER_VARS["HTTP_HOST"]; ?>:<?php echo ("$port"); ?>/stream.m3u" target="_blank" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Button_Play','','icecast.images/button_play_focus.png',1)"><img src="icecast.images/button_play.png" alt="Play Ices0 stream" name="Button_Play" id="Button_Play" border="0" align="absmiddle" /></a></span></td>
          <td width="20"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><img src="icecast.images/window_menu_bg_bottom_line.png" width="1000" height="4" /></td>
    </tr>
    <tr>
      <td height="541" align="center" valign="middle" background="icecast.images/window_content_bg.png"><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="2"></td>
	<td>error.log</td>
	<td width="2"></td>
  </tr>
  <tr>
    <td width="2" height="2"><img src="icecast.images/box_border_tl.png" width="2" height="2" /></td>
    <td height="2" background="icecast.images/box_border_t.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
    <td width="2" height="2"><img src="icecast.images/box_border_tr.png" width="2" height="2" /></td>
  </tr>
  <tr>
    <td width="2" background="icecast.images/box_border_ml.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
    <td width="430" height="200" bgcolor="#c8ccd2" class="t12b"><label><textarea name="log" class="log" id="log"><?php
      $data = " ";
		$file = "/usr/bin/icestation/var/log/icecast/error.log";
		if (file_exists($file)) {
		$Handle = fopen($file, "rb");
		if (filesize($file) > 0) {
		  $data = fread($Handle, filesize($file));
		}
		fclose($Handle);
		echo $data;
		}
      ?></textarea></label></td>
    <td width="2" background="icecast.images/box_border_mr.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
  </tr>
  <tr>
    <td width="2" height="2"><img src="icecast.images/box_border_bl.png" width="2" height="2" /></td>
    <td height="2" background="icecast.images/box_border_b.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
    <td width="2" height="2"><img src="icecast.images/box_border_br.png" width="2" height="2" /></td>
  </tr>
</table><br /><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="2"></td>
	<td>access.log</td>
	<td width="2"></td>
  </tr>
  <tr>
    <td width="2" height="2"><img src="icecast.images/box_border_tl.png" width="2" height="2" /></td>
    <td height="2" background="icecast.images/box_border_t.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
    <td width="2" height="2"><img src="icecast.images/box_border_tr.png" width="2" height="2" /></td>
  </tr>
  <tr>
    <td width="2" background="icecast.images/box_border_ml.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
    <td width="430" height="200" bgcolor="#c8ccd2" class="t12b"><label><textarea name="log" class="log" id="log"><?php
      $data = " ";
		$file = "/usr/bin/icestation/var/log/icecast/access.log";
		if (file_exists($file)) {
		$Handle = fopen($file, "rb");
		if (filesize($file) > 0) {
		  $data = fread($Handle, filesize($file));
		}
		fclose($Handle);
		echo $data;
		}
      ?></textarea></label></td>
    <td width="2" background="icecast.images/box_border_mr.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
  </tr>
  <tr>
    <td width="2" height="2"><img src="icecast.images/box_border_bl.png" width="2" height="2" /></td>
    <td height="2" background="icecast.images/box_border_b.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
    <td width="2" height="2"><img src="icecast.images/box_border_br.png" width="2" height="2" /></td>
  </tr>
</table></td>
    </tr>
    <tr>
      <td height="48" background="icecast.images/window_bottom.png"><table width="1000" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="19" height="29"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
          <td width="200" align="center" valign="middle"><span class="v10white">© Mariusz Grzybacz ^SiLAS</span></td>
          <td><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
          <td width="113" align="center" valign="middle" class="v10white">v2.0.0 b1023</td>
          <td width="18"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
        </tr>
        <tr>
          <td height="19" colspan="5"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
</body>
</html>
