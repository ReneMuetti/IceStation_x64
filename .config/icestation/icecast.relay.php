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
form {
	border:0px;
	padding:0px;
	margin:0px;
}
input.custom1 {
    width:135px;
	height:16px;
	font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	background-color: #cad1d7;
	color: #1d232b;
	border:none;
}
input.custom2 {
    width:36px;
	height:16px;
	font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	background-color: #cad1d7;
	color: #1d232b;
	border:none;
}
input.custom3 {
    width:91px;
	height:16px;
	font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	background-color: #cad1d7;
	color: #1d232b;
	border:none;
}
a {
	color: #000000;
	text-decoration: none;
}
a:link { text-decoration: underline;
	color: #122334;}
a:visited { text-decoration: none; }
a:hover { text-decoration: none; }
a:unknown { text-decoration: none; }
a:active { text-decoration: none; }
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
	MM_preloadImages('icecast.images/button_add_server_focus.png');
	so_checkCanCreate();
}

function so_checkCanCreate() {
	// make sure the browser has images turned on. If they are, so_createCustomCheckBoxes will
	// fire when this small test image loads. otherwise, the user will get the hard-coded checkboxes
	testImage = d.body.appendChild(d.createElement("img"));

	// MSIE will cache the test image, causing it to not fire the onload event the next time the
	// page is hit. The parameter on the end will prevent this.
	testImage.src = "icecast.images/blank.gif?" + new Date().valueOf();
	testImage.id = "so_testImage";
	testImage.onload = so_createCustomCheckBoxes;
}

function so_createCustomCheckBoxes() {
	// bail out is this is an older browser
	if(!d.getElementById)return;
	// remove our test image from the DOM
	d.body.removeChild(d.getElementById("so_testImage"));
	// an array of applicable events that we'll need to carry over to our custom checkbox
	events = new Array("onfocus", "onblur", "onselect", "onchange", "onclick", "ondblclick", "onmousedown", "onmouseup", "onmouseover", "onmousemove", "onmouseout", "onkeypress", "onkeydown", "onkeyup");
	// a reference var to all the forms in the document

	frm = d.getElementsByTagName("form");
	// loop over the length of the forms in the document
	for(i=0;i<frm.length;i++) {
		// reference to the elements of the form
		c = frm[i].elements;
		// loop over the length of those elements
		for(j=0;j<c.length;j++) {
			// if this element is a checkbox, do our thing

			if(c[j].getAttribute("type") == "checkbox") {
				// hide the original checkbox
				c[j].style.position = "absolute";
				c[j].style.left = "-9000px";
				// create the replacement image
				n = d.createElement("img");
				n.setAttribute("class","chk");
				// check if the corresponding checkbox is checked or not. set the
				// status of the image accordingly
				if(c[j].checked == false) {
					n.setAttribute("src","icecast.images/checkbox_off.png");
					n.setAttribute("title","click here to select this option.");
					n.setAttribute("alt","click here to select this option.");
				} else {
					n.setAttribute("src","icecast.images/checkbox_on.png");
					n.setAttribute("title","click here to deselect this option.");
					n.setAttribute("alt","click here to deselect this option.");
				}
				// there are several pieces of data we'll need to know later.
				// assign them as attributes of the image we've created
				// first - the name of the corresponding checkbox
				n.xid = c[j].getAttribute("name");
				// next, the index of the FORM element so we'll know which form object to access later

				n.frmIndex = i;
				// assign the onclick event to the image
				n.onclick = function() { so_toggleCheckBox(this,0);return false; }
				// insert the image into the DOM
				c[j].parentNode.insertBefore(n,c[j].nextSibling)
				// this attribute is a bit of a hack - we need to know in the event of a label click (for browsers that support it)
				// which image we need turn on or off. So, we set the image as an attribute!
				c[j].objRef = n;
				// assign the checkbox objects event handlers to its replacement image
				for(e=0;e<events.length;e++) if(eval('c[j].' +events[e])) eval('n.' + events[e] + '= c[j].' + events[e]);
				// append our onchange event handler to any existing ones.
				fn = c[j].onchange;
				if(typeof(fn) == "function") {
					c[j].onchange = function() { fn(); so_toggleCheckBox(this.objRef,1); return false; }
				} else {
					c[j].onchange = function () { so_toggleCheckBox(this.objRef,1); return false; }
				}
			}
		}
	}
}

function so_toggleCheckBox(imgObj,caller) {
	// if caller is 1, this method has been called from the onchange event of the checkbox, which means
	// the user has clicked the label element. Dont change the checked status of the checkbox in this instance
	// or we'll set it to the opposite of what the user wants. caller is 0 if coming from the onclick event of the image
	
	// reference to the form object
	formObj = d.forms[imgObj.frmIndex];
	// the name of the checkbox we're changing
	objName = imgObj.xid;
	// change the checked status of the checkbox if coming from the onclick of the image
	if(!caller)formObj.elements[objName].checked = !formObj.elements[objName].checked?true:false;
	// finally, update the image to reflect the current state of the checkbox.
	if(imgObj.src.indexOf("icecast.images/checkbox_on.png")>-1) {
		imgObj.setAttribute("src","icecast.images/checkbox_off.png");
		imgObj.setAttribute("title","click here to select this option.");
		imgObj.setAttribute("alt","click here to select this option.");
	} else {
		imgObj.setAttribute("src","icecast.images/checkbox_on.png");
		imgObj.setAttribute("title","click here to deselect this option.");
		imgObj.setAttribute("alt","click here to deselect this option.");
	}
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

function ReloadPlaylist () {
var f = document.getElementById('playlist');
f.src = f.src;
}

function checkclear(what){
if(!what._haschanged){
  what.value=''
};
what._haschanged=true;
}

//-->
</script>
<script type="text/javascript" language="JavaScript">
function noempty()
{
    if ( document.form.relay_server.value == '' || document.form.relay_port.value == '' || document.form.relay_mountpath.value == '' )
    {
        alert('One field is empty! Fill it!')
        return false;
    }
}
</script>
</head>
<?php
  include ("icecast.relay.includes.php");
  if ($_GET['relay_ondemand'] == "on") {
    $relay_ondemand = "1";
  } else {
    $relay_ondemand = "0";
  }
	
  if ($_GET['relay_metadata'] == "on") {
    $relay_metadata = "1";
  } else {
    $relay_metadata = "0";
  }
	
  if ($_GET['action'] == "send") {
  $File = "icecast.relay.includes.php"; 
  $Handle = fopen($File, 'w');
  $localmount = rand(100000, 999999);
  $sepprefix = "";
  if ($relay != "") {
    $sepprefix = "#";
  }
  $nrelay = $relay . $sepprefix . $_GET['relay_server'] . '|' . $_GET['relay_port'] . '|' . $_GET['relay_mountpath'] . '|/' . $localmount . '|' . $relay_ondemand . '|' . $relay_metadata;
  $Data = '<?php
$relay = "' . $nrelay .'";
?>';
 
  fwrite($Handle, $Data); 
  fclose($Handle); 
  }
  include ("icecast.relay.includes.php");
  include ("icecast.functions.php");
  
//  generate_configs();
?>
<body>
<div align="left">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5"><img src="icecast.images/spacer.gif" width="5" height="5" /></td>
    <td><form action="icecast.relay.php" method="get" name="form" onSubmit="return noempty();"><input type="hidden" name="action" id="action" value="send" />
<table width="403" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="middle"><table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="middle"><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="2" height="2"><img src="icecast.images/box_border_tl.png" width="2" height="2" /></td>
                <td height="2" background="icecast.images/box_border_t.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                <td width="2" height="2"><img src="icecast.images/box_border_tr.png" width="2" height="2" /></td>
              </tr>
              <tr>
                <td width="2" background="icecast.images/box_border_ml.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                <td bgcolor="#c8ccd2"><label>
                  <input class="custom1" type="text" name="relay_server" id="relay_server" value="relay server address" onfocus="checkclear(this)" />
                </label></td>
                <td width="2" background="icecast.images/box_border_mr.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
              </tr>
              <tr>
                <td width="2" height="2"><img src="icecast.images/box_border_bl.png" width="2" height="2" /></td>
                <td height="2" background="icecast.images/box_border_b.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                <td width="2" height="2"><img src="icecast.images/box_border_br.png" width="2" height="2" /></td>
              </tr>
            </table></td>
            <td width="6" align="center" valign="middle">:</td>
            <td align="center" valign="middle"><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="2" height="2"><img src="icecast.images/box_border_tl.png" width="2" height="2" /></td>
                <td height="2" background="icecast.images/box_border_t.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                <td width="2" height="2"><img src="icecast.images/box_border_tr.png" width="2" height="2" /></td>
              </tr>
              <tr>
                <td width="2" background="icecast.images/box_border_ml.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                <td bgcolor="#c8ccd2"><label>
                  <input class="custom2" type="text" name="relay_port" id="relay_port" value="port" onfocus="checkclear(this)" />
                </label></td>
                <td width="2" background="icecast.images/box_border_mr.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
              </tr>
              <tr>
                <td width="2" height="2"><img src="icecast.images/box_border_bl.png" width="2" height="2" /></td>
                <td height="2" background="icecast.images/box_border_b.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                <td width="2" height="2"><img src="icecast.images/box_border_br.png" width="2" height="2" /></td>
              </tr>
            </table></td>
            <td width="2" align="center" valign="middle"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
            <td align="center" valign="middle"><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="2" height="2"><img src="icecast.images/box_border_tl.png" width="2" height="2" /></td>
                <td height="2" background="icecast.images/box_border_t.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                <td width="2" height="2"><img src="icecast.images/box_border_tr.png" width="2" height="2" /></td>
              </tr>
              <tr>
                <td width="2" background="icecast.images/box_border_ml.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                <td bgcolor="#c8ccd2"><label>
                  <input class="custom3" type="text" name="relay_mountpath" id="relay_mountpath" value="/mount path" onfocus="checkclear(this)" />
                </label></td>
                <td width="2" background="icecast.images/box_border_mr.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
              </tr>
              <tr>
                <td width="2" height="2"><img src="icecast.images/box_border_bl.png" width="2" height="2" /></td>
                <td height="2" background="icecast.images/box_border_b.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                <td width="2" height="2"><img src="icecast.images/box_border_br.png" width="2" height="2" /></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="middle"><img src="icecast.images/spacer.gif" width="1" height="3" /></td>
      </tr>
      <tr>
        <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="120" align="left" valign="middle"><label><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="23" align="center" valign="middle"><input type="checkbox" class="chk" name="relay_ondemand" id="relay_ondemand" checked="checked" /></td>
    <td align="left" valign="middle"><img src="icecast.images/spacer.gif" width="7" height="1" /><label alt="When this option is set, Icecast will connect to relay server only when user will open this mount to listening">On-demand</label></td>
  </tr>
</table>
</label></td>
    <td align="left" valign="middle"><label><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="23" align="center" valign="middle"><input type="checkbox" class="chk" name="relay_metadata" id="relay_metadata" /></td>
    <td align="left" valign="middle"><img src="icecast.images/spacer.gif" width="7" height="1" />Meta-data</td>
  </tr>
</table>
</label></td>
  </tr>
</table>
&nbsp;</td>
      </tr>
    </table></td>
    <td width="102" align="center" valign="middle"><input type="image" src="icecast.images/button_add_server.png" alt="Add relay server to the list..." name="button_add_server" width="102" height="31" border="0" id="button_add_server" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('button_add_server','','icecast.images/button_add_server_focus.png',1)" /></a></td>
  </tr>
</table>
</form>


<?php

  if ($_GET['action'] == "send") {
    echo '<font color="#ff3333"><strong>After update, remember to restart IceStation.</strong></font>';
  }
	
?><table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td width="11" align="center" valign="middle" bgcolor="#b3b7bd"><strong>D</strong></td>
        <td align="center" valign="middle" bgcolor="#b3b7bd"><strong>Adress</strong></td>
        <td align="center" valign="middle" bgcolor="#b3b7bd"><strong>Port</strong></td>
        <td align="center" valign="middle" bgcolor="#b3b7bd"><strong>Mount path</strong></td>
        <td align="center" valign="middle" bgcolor="#b3b7bd"><strong>Local path</strong></td>
        <td align="center" valign="middle" bgcolor="#b3b7bd"><strong>O</strong></td>
        <td align="center" valign="middle" bgcolor="#b3b7bd"><strong>M</strong></td>
      </tr>
<?php

include "icecast.includes.php";

if ($relay != "") {

  $relays = explode('#', $relay);
  $n = 0;
  foreach ($relays as &$value) {
    $n = $n + 1;
    echo '<tr><td align="center" valign="middle" bgcolor="#bec2c7"><a href="icecast.relay.del.php?id=' . $n .'"><img src="icecast.images/icon_remove.png" alt="Delete this relay server" /></a></td>';
    $drelays = explode('|', $value);
	$y = 0;
	foreach ($drelays as &$dvalue) {
	  $y = $y + 1;
	  if ($y == 4) {
        echo '<td align="left" valign="middle" bgcolor="#bec2c7"><a href="http://' . $HTTP_SERVER_VARS["HTTP_HOST"] . ':' . $port . $dvalue . '.m3u">' . $dvalue . '</a></td>';
	  } else {
        echo '<td align="left" valign="middle" bgcolor="#bec2c7">' . $dvalue . '</td>';
	  }
    }
	echo '</tr>';
  }

}
?>
    </table></td>
    <td width="3"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
  </tr>
</table><br />


</div>
</body>
</html>