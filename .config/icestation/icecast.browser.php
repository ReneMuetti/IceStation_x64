<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<title>QNAP IceStation - Browser</title>
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
	text-decoration: none;
}
a:link { text-decoration: none; }
a:visited { text-decoration: none; }
a:hover { text-decoration: underline; }
a:unknown { text-decoration: none; }
a:active { text-decoration: none; }
-->
</style>
</head>
<body>
<div align="left">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
    <td><?php
	  
if ($_GET['dir'] == "") {
  $dir = "/share/Qmultimedia/";
} else {
  $dir = $_GET['dir'];
}

$pathlength = strlen($dir);
$path = $dir;
if ($pathlength > 40) {
  $path = substr ($path, $pathlength - 40, $pathlength);
  $path = '...' . $path;
}

?>

<table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="2" height="2"><img src="icecast.images/box_border_tl.png" width="2" height="2" /></td>
                            <td height="2" background="icecast.images/box_border_t.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                            <td width="2" height="2"><img src="icecast.images/box_border_tr.png" width="2" height="2" /></td>
                          </tr>
                          <tr>
                            <td width="2" background="icecast.images/box_border_ml.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                            <td bgcolor="#c8ccd2"><table width="0%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td><img src="icecast.images/editbox_caption_path.png" alt="Local path" width="76" height="20" /></td>
                                <td valign="middle" width="306"><img src="icecast.images/spacer.gif" alt=" " width="2" height="1" align="bottom" /><img src="icecast.images/icon_folder.png" alt="Open directory" align="absmiddle" /><img src="icecast.images/spacer.gif" alt=" " width="6" height="1" align="bottom" /><? echo $path; ?></td>
                              </tr>
                            </table></td>
                            <td width="2" background="icecast.images/box_border_mr.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                          </tr>
                          <tr>
                            <td width="2" height="2"><img src="icecast.images/box_border_bl.png" width="2" height="2" /></td>
                            <td height="2" background="icecast.images/box_border_b.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                            <td width="2" height="2"><img src="icecast.images/box_border_br.png" width="2" height="2" /></td>
                          </tr>
                        </table><img src="icecast.images/spacer.gif" alt=" " width="1" height="7" />

<table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td align="center" valign="middle" bgcolor="#b3b7bd"><img src="icecast.images/spacer.gif" alt=" " width="1" height="1" /></td>
        <td align="left" valign="middle" bgcolor="#b3b7bd"><img src="icecast.images/spacer.gif" alt=" " width="5" height="1" /><strong>Name</strong></td>
      </tr>

<?  

	  
$directory = dir ("$dir");

while (($item = $directory->read()) !== false) {
  if ($item != "." && $item != "..") {
    $path = "{$directory->path}/{$item}";

    if (is_dir($path)) {
      $tmp['name'] = $item;
//      $tmp['stats'] = lstat($path);
  
      $dirs[$item] = $tmp;
  
      unset($tmp);
    } elseif (is_file($path)) {
      $tmp['name'] = $item;
//      $tmp['stats'] = lstat($path);
      $tmp['extension'] = substr($item, strrpos($item, "."));
  
      $files[] = $tmp;
  
      unset($tmp);
    }
  }
}

$dirscount = count($dirs);
if ($dirscount > 0) {
  ksort($dirs, SORT_STRING);
  sort($dirs);
}

$filescount = count($files);
if ($filescount > 0) {
  ksort($files, SORT_STRING);
  sort($files);
}

$pos = strrpos ($dir, '/');
$cdup = substr ($dir, 0, $pos);
$pos = strrpos ($cdup, '/');
$cdup = substr ($cdup, 0, $pos);
$cdup .= "/";

echo '<tr><td align="center" valign="middle" bgcolor="#bec2c7" width="20" height="19"><img src="icecast.images/spacer.gif" alt=" " width="1" height="1" /></td>';
echo '<td height="19" align="left" valign="middle" bgcolor="#bec2c7"><a href="' . $_SERVER['PHP_SELF'] . '?dir=' . urlencode($cdup) . urlencode($details['name']) . '"><img src="icecast.images/spacer.gif" alt=" " width="2" height="1" /><img src="icecast.images/icon_cdup.png" alt="CDUP" align="absmiddle" /><img src="icecast.images/spacer.gif" alt=" " width="2" height="1" align="bottom" /><img src="icecast.images/spacer.gif" alt=" " width="2" height="1" />..</a></td></tr>';

if ($dirscount > 0) {
  foreach ($dirs as $details) {
    echo '<tr><td align="center" valign="middle" bgcolor="#bec2c7" width="20" height="19"><a href="icecast.playlist.php?action=adddirectory&name=' . $dir . $details['name'] . '" target="playlist"><img src="icecast.images/icon_play.png" alt="Add music files from this directory to playlist" /></a></td>';
    echo '<td height="19" align="left" valign="middle" bgcolor="#bec2c7"><a href="' . $_SERVER['PHP_SELF'] . '?dir=' . urlencode($dir) . urlencode($details['name']) . '/' . '"><img src="icecast.images/spacer.gif" alt=" " width="2" height="1" align="bottom" /><img src="icecast.images/icon_folder.png" alt="Open directory" align="absmiddle" /><img src="icecast.images/spacer.gif" alt=" " width="4" height="1" align="bottom" />' . $details['name'] . '</a></td></tr>';
  }
}


if ($filescount > 0) {
  foreach ($files as $details) {
    if (strtoupper($details['extension']) == ".MP3")
    {
      echo '<tr><td align="center" valign="middle" bgcolor="#bec2c7" width="20" height="19"><a href="icecast.playlist.php?action=addfile&name=' . urlencode($dir) . urlencode($details['name']) . '" target="playlist"><img src="icecast.images/icon_play.png" alt="Add to playlist this track only" /></a></td>';
      echo '<td height="19" align="left" valign="middle" bgcolor="#bec2c7"><a href="icecast.playlist.php?action=addfile&name=' . urlencode($dir) . urlencode($details['name']) . '" target="playlist"><img src="icecast.images/icon_music.png" alt="Add to playlist this track only" align="absmiddle" /><img src="icecast.images/spacer.gif" alt=" " width="4" height="1" align="bottom" />' . $details['name'] . '</a></td></tr>';
    }
  }
}

?></table></td>
    <td width="3"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
  </tr>
</table><br /></div>
</body>
</html>