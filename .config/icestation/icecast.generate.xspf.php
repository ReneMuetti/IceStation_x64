<?
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header('Content-type: multimedia/xspf');
header('Content-Disposition: attachment; filename="playlist.xspf"');

include ("icecast.playlist.includes.php");
?>
<? echo '<?xml version="1.0" encoding="UTF-8" standalone="no" ?>'; ?>

<playlist version="1" xmlns="http://xspf.org/ns/0/" xml:base="file://<?=$HTTP_SERVER_VARS["HTTP_HOST"] ?><?=$path ?>>

  <title>IceStation XSPF Playlist</title>
  
	<trackList>
<?
include "id3.php";

$lines = array_map('rtrim',file('icecast.playlist.txt'));
$doublebackslash = ("\\\\");

foreach ($lines as $line_num => $line) {
    $file = $line;
    $obj_tag = new id3 ( $file );
    $obj_tag -> readtags ( $file );
    $artist = $obj_tag -> artist ();
    $title = $obj_tag -> title ();
?>

		<track>

			<title><?=$title ?></title>
			<creator><?=$artist ?></creator>
			<location><?

$file = str_replace("/share","",$file);
$file = str_replace($path,"",$file);
print $file;

?></location>

		</track>

<?
}
?>
	</trackList>

</playlist>