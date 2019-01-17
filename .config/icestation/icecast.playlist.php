<?php

  function generate_selected($selectedfile, $playlist, $selectedfile2, $playlistfile) {
    $fh = fopen($selectedfile, 'w') or die("can't open file");
    fwrite($fh, $playlist);
    fclose($fh);
	
	$fh = fopen($selectedfile2, 'w') or die("can't open file");
    fwrite($fh, $playlistfile);
    fclose($fh);
  }

  $message = "";
  $warn = 0;

  $playlistsfile = "icecast.playlists.txt";
  $selectedfile = "icecast.selected.playlist.txt";
  $selectedfile2 = "icecast.selected.playlist.filename.txt";

  if ($_GET['playlist'] == ""){
      $lines = file($selectedfile);
	  $playlist = $lines[0];
  } else {
      $playlist = $_GET['playlist'];
  }
  
  $playlistfile = "icecast.playlist." . $playlist . ".txt";

  if ($_GET['action'] == "choose") {
  
    generate_selected($selectedfile, $playlist, $selectedfile2, $playlistfile);
  
  }
  
  
  function getDirectory($path = '.', $ignore = '') { 
    $ignore[] = '.'; 
    $ignore[] = '..'; 
	
	$lines = "";

    $dh = @opendir($path); 

    while (false !== ($file = readdir($dh)))
	{ 

        if (!in_array($file, $ignore))
		{ 
            if (!is_dir("$path/$file"))
			{
			    $name = $path . "/" . $file;
			    $ext = substr($name, strrpos($name, "."));
				if (strtoupper($ext) == ".MP3")
				{
				  $name = str_replace("//","/",$name);
                  $lines .= $name . "\n";
				}
            } else { 
                $linesTemp = getDirectory("$path/$file", $ignore); 
                if ($linesTemp <> "") { $lines .= $linesTemp; }
            } 
        } 
    } 
    closedir($dh); 
     
    return $lines; 
  }

  
  if ($_GET['action'] == "delete") {
    
	$name = $_GET['name'];
  
    if ($name <> "On-The-Go") {
      $lines = file($playlistsfile);
	
      $newlines   = array("\r\n", "\n", "\r");
	
      if ($lines <> "") {
        foreach ($lines as $line_num => $line) {
          $line = str_replace($newlines, "", $line);
	      if ($name <> $line) {
		    $newlist .= $line . "\n";
		  }
	    }
      }

	  $fh = fopen($playlistsfile, 'w') or die("can't open file");
      fwrite($fh, $newlist);
      fclose($fh);
	  unlink ("icecast.playlist." . $name . ".txt");
	  $warn = 1;
	  $message = "Playlist ". $name . " has been deleted.";
	} else {
	  $warn = 2;
	  $message = "Unable to delete On-The-Go playlist. It's a default IceStation playlist";
    }
	
	$playlist = "On-The-Go";
	$playlistfile = "icecast.playlist." . $playlist . ".txt";
	generate_selected($selectedfile, $playlist, $selectedfile2, $playlistfile);
	
  }
  
  
  if ($_GET['action'] == "clear") {
  
    $name = $_GET['name'];
  
    $fh = fopen("icecast.playlist." . $name . ".txt", 'w') or die("can't open file");
	fwrite($fh, "");
	fclose($fh);
	
    $warn = 1;
	$message = "Playlist " . $playlistname . " has been cleared!";
	
  }
  
  
  if ($_GET['action'] == "create") {
  
    $playlistname = "";
	$defaultname = "My playlist";
	$i = 0;
	
	while ($playlistname == "") {
	  if ($i == 0) {
	    $tempname = $defaultname;
	  } else {
	    $tempname = $defaultname . " " . $i;
	  }
	  if (!file_exists ("icecast.playlist." . $tempname . ".txt")) {
        $playlistname = $tempname;
      }	
      $i++;	  
	}
	
	$data = $playlistname . "\n";
  
    $fh = fopen($playlistsfile, 'a') or die("can't open file");
    fwrite($fh, $data);
    fclose($fh);
	
	$fh = fopen("icecast.playlist." . $playlistname . ".txt", 'w') or die("can't open file");
	fwrite($fh, "");
	fclose($fh);
	
    $warn = 1;
	$message = "Playlist " . $playlistname . " has been created!";
	
	$playlist = $playlistname;
	$playlistfile = "icecast.playlist." . $playlist . ".txt";
	generate_selected($selectedfile, $playlist, $selectedfile2, $playlistfile);

  }
  
  
  if ($_GET['action'] == "saveas") {
  
    $saveas = $_GET['saveas'];
  
    $from = "icecast.playlist." . $playlist . ".txt";
	$to = "icecast.playlist." . $saveas . ".txt";
	
	if (file_exists($to)) {
	  $warn = 2;
	  $message = "Playlist " . $saveas . " already exists!";
	} else {
      if (!copy($from, $to)) {
        $warn = 2;
	    $message = "Unable to save playlist " . $saveas;
      }
	  $data = $saveas . "\n";
  
      $fh = fopen($playlistsfile, 'a') or die("can't open file");
      fwrite($fh, $data);
      fclose($fh);
	  
	  $warn = 1;
	  $message = "Playlist " . $playlist . " has been saved as " . $saveas;
	
	  $playlist = $saveas;
	  $playlistfile = "icecast.playlist." . $playlist . ".txt";
	  generate_selected($selectedfile, $playlist, $selectedfile2, $playlistfile);
	}
	
  }
  
  
  if ($_GET['action'] == "addfile") {
  
    $name = $_GET['name'];
  
    $data = $name . "\n";
  
    $fh = fopen($playlistfile, 'a') or die("can't open file");
    fwrite($fh, $data);
    fclose($fh);
  
  }

  
  if ($_GET['action'] == "adddirectory") {
  
    $name = $_GET['name'];
    
	$lines = getDirectory($name);
	
	if ($lines <> "") {
	  $fh = fopen($playlistfile, 'a') or die("can't open file");
      fwrite($fh, $lines);
	  fclose($fh);
	}
	
  }

  
  if ($_GET['action'] == "deleteitem") {
  
    $num = $_GET['num'];

    $data = "";
    if (file_exists($playlistfile)) {
      $lines = file($playlistfile);

      foreach ($lines as $line_num => $line) {
        if ($num <> $line_num)
		{
		  $data .= $line;
		}
	  }
	}
	$fh = fopen($playlistfile, 'w') or die("can't open file");
    fwrite($fh, $data);
	fclose($fh);

  }
  
  if ($_GET['action'] == "moveup") {
  
    $num = $_GET['num'];
	$linebefore = "";

    $data = "";
    if (file_exists($playlistfile)) {
      $lines = file($playlistfile);

      foreach ($lines as $line_num => $line) {
	    if ($num - 1 == $line_num)
		{
		  $linebefore = $line;
		}
		if ($num == $line_num)
		{
		  $data .= $line . $linebefore;
		}
		if ($num <> $line_num && $num - 1 <> $line_num)
		{
		  $data .= $line;
		}
	  }
	}
	$fh = fopen($playlistfile, 'w') or die("can't open file");
    fwrite($fh, $data);
	fclose($fh);

  }

  if ($_GET['action'] == "movedown") {
  
    $num = $_GET['num'];
	$linetomove = "";
	$lineafter = "";

    $data = "";
    if (file_exists($playlistfile)) {
      $lines = file($playlistfile);

      foreach ($lines as $line_num => $line) {
	    if ($num == $line_num)
		{
		  $linetomove = $line;
		}
		if ($num + 1 == $line_num)
		{
		  $lineafter = $line;
		  $data .= $lineafter . $linetomove;
		}
		if ($num <> $line_num && $num + 1 <> $line_num)
		{
		  $data .= $line;
		}
	  }
	}
	if ($lineafter == "")
	{
	  $data .= $linetomove;
	}
	$fh = fopen($playlistfile, 'w') or die("can't open file");
    fwrite($fh, $data);
	fclose($fh);

  }
  
?>
  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<title>QNAP IceStation - Playlist view</title>
<style type="text/css">
<!--
img, div, a, input { behavior: url(icecast.images/iepngfix.htc) }
body {
	background-color: #c8ccd2;
	margin: 2px;
	padding: 2px;
}
body,td,th {
	font-family: Trebuchet MS, Calibri, Arial, Tahoma;
	font-size: 10px;
	color: #1d232b;
}
img {
	border:0px;
}
a {
	color: #000000;
	text-decoration: underline;
}
a:link { text-decoration: underline; }
a:visited { text-decoration: underline; }
a:hover { text-decoration: none; }
a:unknown { text-decoration: underline; }
a:active { text-decoration: underline; }

.stdwhite {
    color: #ffffff;
}

form {
	border:0px;
	padding:0px;
	margin:0px;
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

input.saveas {
    width:74px;
	height:16px;
	font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	background-color: #cad1d7;
	color: #1d232b;
	border:none;
}

select.playlist {
    width:314px;
	height:20px;
	font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	background-color: #cad1d7;
	color: #1d232b;
	border:none;
}

select.action {
    width:81px;
	height:20px;
	font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	background-color: #cad1d7;
	color: #1d232b;
	border:none;
}
-->
</style>
<script type="text/javascript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

window.onload = init;
var d=document;
function init() {
	MM_preloadImages('icecast.images/button_ok_focus.png');
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>
<body>
<div align="left">
<?php
  if ($warn <> 0) {?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" <?
if ($warn == 2) { ?>bgcolor="#c27575"<? } else { ?>bgcolor="#5f8dab"<? } ?>>
  <tr>
    <td colspan="3"><img src="icecast.images/spacer.gif" alt=" " width="1" height="5" /></td>
  </tr>
  <tr>
    <td><img src="icecast.images/spacer.gif" alt=" " width="10" height="1" /></td>
    <td valign="middle" align="left"><span class="stdwhite"><strong><? echo $message; ?></strong></span></td>
	<td><img src="icecast.images/spacer.gif" alt=" " width="10" height="1" /></td>
  </tr>
  <tr>
    <td colspan="3"><img src="icecast.images/spacer.gif" alt=" " width="1" height="5" /></td>
  </tr>
</table>
<?
  }
?>
<img src="icecast.images/spacer.gif" alt=" " width="1" height="5" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#a0a3a8">
  <tr>
    <td><img src="icecast.images/spacer.gif" alt=" " width="1" height="47" /></td>
    <td align="center" valign="middle"><form action="icecast.playlist.php" method="get"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="387" valign="middle" align="center"><table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="2" height="2"><img src="icecast.images/box_border_tl.png" width="2" height="2" /></td>
                            <td height="2" background="icecast.images/box_border_t.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                            <td width="2" height="2"><img src="icecast.images/box_border_tr.png" width="2" height="2" /></td>
                          </tr>
                          <tr>
                            <td width="2" background="icecast.images/box_border_ml.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                            <td bgcolor="#c8ccd2"><table width="0%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td><img src="icecast.images/editbox_caption_playlist.png" alt="Select playlist" width="69" height="20" /></td>
                                <td valign="middle"><select name="playlist" id="playlist" class="playlist" onchange="location = this.options[this.selectedIndex].value;">
<?
$lines = file($playlistsfile);

$newlines   = array("\r\n", "\n", "\r");

if ($lines <> "") {
  foreach ($lines as $line_num => $line) {
    $line = str_replace($newlines, "", $line);
    echo '<option value="' . $_SERVER['PHP_SELF'] . '?action=choose&playlist=' . $line . '"';
	if ($playlist == $line) {
	  echo ' selected="selected"';
	}
	echo '>'. $line .'</option>';
  }
}
?>
</select></td>
                              </tr>
                            </table></td>
                            <td width="2" background="icecast.images/box_border_mr.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                          </tr>
                          <tr>
                            <td width="2" height="2"><img src="icecast.images/box_border_bl.png" width="2" height="2" /></td>
                            <td height="2" background="icecast.images/box_border_b.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                            <td width="2" height="2"><img src="icecast.images/box_border_br.png" width="2" height="2" /></td>
                          </tr>
                        </table></td>
	  </tr>
	</table></form></td>
    <td><img src="icecast.images/spacer.gif" alt=" " width="1" height="47" /></td>
  </tr>
</table>
<img src="icecast.images/spacer.gif" alt=" " width="1" height="12" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="icecast.images/spacer.gif" alt=" " width="1" height="1" /></td>
    <td width="154 valign="middle" align="right"><table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="2" height="2"><img src="icecast.images/box_border_tl.png" width="2" height="2" /></td>
                            <td height="2" background="icecast.images/box_border_t.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                            <td width="2" height="2"><img src="icecast.images/box_border_tr.png" width="2" height="2" /></td>
                          </tr>
                          <tr>
                            <td width="2" background="icecast.images/box_border_ml.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                            <td bgcolor="#c8ccd2"><table width="0%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td><img src="icecast.images/editbox_caption_action.png" alt="Select action" width="69" height="20" /></td>
                                <td valign="middle"><select name="action" id="action" class="action" onchange="location = this.options[this.selectedIndex].value;">
  <option value="<?php echo $_SERVER['PHP_SELF']; ?>">- select -</option>
  <option value="<?php echo $_SERVER['PHP_SELF'] . "?action=create"; ?>">Create</option>
  <option value="<?php echo $_SERVER['PHP_SELF'] . "?action=delete&name=$playlist"; ?>">Delete</option>
  <option value="<?php echo $_SERVER['PHP_SELF'] . "?action=clear&name=$playlist"; ?>">Clear</option>
</select></td>
                              </tr>
                            </table></td>
                            <td width="2" background="icecast.images/box_border_mr.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                          </tr>
                          <tr>
                            <td width="2" height="2"><img src="icecast.images/box_border_bl.png" width="2" height="2" /></td>
                            <td height="2" background="icecast.images/box_border_b.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                            <td width="2" height="2"><img src="icecast.images/box_border_br.png" width="2" height="2" /></td>
                          </tr>
                        </table></td>
    <td><img src="icecast.images/spacer.gif" alt=" " width="1" height="1" /></td>
    <td width="207" valign="middle" align="left"><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" name="form" onSubmit="return noempty();"><input type="hidden" name="action" value="saveas"><input type="hidden" name="playlist" value="<? echo $playlist; ?>"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="154" align="left" valign="middle"><table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="2" height="2"><img src="icecast.images/box_border_tl.png" width="2" height="2" /></td>
                            <td height="2" background="icecast.images/box_border_t.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                            <td width="2" height="2"><img src="icecast.images/box_border_tr.png" width="2" height="2" /></td>
                          </tr>
                          <tr>
                            <td width="2" background="icecast.images/box_border_ml.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                            <td bgcolor="#c8ccd2"><table width="0%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td><img src="icecast.images/editbox_caption_save_as.png" alt="Save playlist" width="76" height="20" /></td>
                                <td valign="middle"><label><input class="saveas" type="text" name="saveas" id="saveas" value="My playlist" /></label></td>
                              </tr>
                            </table></td>
                            <td width="2" background="icecast.images/box_border_mr.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                          </tr>
                          <tr>
                            <td width="2" height="2"><img src="icecast.images/box_border_bl.png" width="2" height="2" /></td>
                            <td height="2" background="icecast.images/box_border_b.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                            <td width="2" height="2"><img src="icecast.images/box_border_br.png" width="2" height="2" /></td>
                          </tr>
                        </table></td>
        <td width="6"><img src="icecast.images/spacer.gif" alt=" " width="1" height="1" /></td>
        <td width="47" align="left" valign="middle"><input type="image" src="icecast.images/button_ok.png" alt="OK" name="button_ok" width="47" height="28" id="button_ok" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('button_ok','','icecast.images/button_ok_focus.png',1)" /></td>
      </tr>
    </table></form></td>
    <td><img src="icecast.images/spacer.gif" alt=" " width="1" height="1" /></td>
  </tr>
</table>
<img src="icecast.images/spacer.gif" alt=" " width="1" height="12" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
	    <td width="25" align="center" valign="middle" bgcolor="#b3b7bd"><strong>A</strong></td>
	    <td width="25" align="center" valign="middle" bgcolor="#b3b7bd"><strong>Pos</strong></td>
        <td width="25" align="center" valign="middle" bgcolor="#b3b7bd"><strong>#</strong></td>
        <td align="center" valign="middle" bgcolor="#b3b7bd"><strong>Path</strong></td>
      </tr>
<?

if (file_exists($playlistfile)) {
  $lines = file($playlistfile);

  foreach ($lines as $line_num => $line) {
    $file = $line;

    $file = str_replace("/share","",$file);
    $realpath = $file;
?>
    <tr>
	  <td bgcolor="#bec2c7" align="center" valign="center"><a href="<?php echo $_SERVER['PHP_SELF'] . "?action=deleteitem&num=$line_num"; ?>"><img src="icecast.images/icon_remove.png" alt="Remove from playlist" border="0" /></a></td>
	  <td bgcolor="#bec2c7" align="center" valign="center"><a href="<?php echo $_SERVER['PHP_SELF'] . "?action=moveup&num=$line_num"; ?>"><img src="icecast.images/icon_up.png" alt="Move Up" border="0" /></a><a href="<?php echo $_SERVER['PHP_SELF'] . "?action=movedown&num=$line_num"; ?>"><img src="icecast.images/icon_down.png" alt="Move Down" border="0" /></a></td>
	  <td bgcolor="#bec2c7" align="right" valign="middle"><?=$line_num ?></td>
	  <td bgcolor="#bec2c7" align="left" valign="middle"><?=$realpath ?></td>
	</tr>
<?
  }
}
?>
    </table></td>
    <td width="3"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
  </tr>
</table><br /></div>
</body>
</html>