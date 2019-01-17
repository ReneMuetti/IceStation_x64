<?php
  include ("icecast.includes.php");
  include ("icecast.playlist.includes.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
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
input.id3editbox {
    width:309px;
	height:16px;
	font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	background-color: #cad1d7;
	color: #1d232b;
	border:none;
}
input.bitrate {
    width:50px;
	height:16px;
	font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	background-color: #cad1d7;
	color: #1d232b;
	border:none;
}
input.channels {
    width:40px;
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
iframe.invisible {
    width:1px;
	height:1px;
	font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	background-color: #666666;
	border-color: #666666;
	color: #666666;
	border:none;
}
iframe.playlist {
    width:433px;
	height:482px;
	font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	background-color: #cad1d7;
	color: #1d232b;
	border:none;
}
iframe.browser {
    width:433px;
	height:378px;
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
.t12b {color: #1d232b}
form {
	border:0px;
	padding:0px;
	margin:0px;
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
	MM_preloadImages('icecast.images/menu_button_show_ices_log_focus.png','icecast.images/menu_button_show_main_log_focus.png','icecast.images/button_restart_icecast_focus.png','icecast.images/button_save_focus.png','icecast.images/menu_button_show_ices_log_focus.png','icecast.images/button_save_focus.png','icecast.images/button_restart_icecast_focus.png','icecast.images/button_generate_focus.png','icecast.images/button_refresh_focus.png','icecast.images/button_play_focus.png','icecast.images/button_jump_to_next_focus.png');
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
          <td width="98" valign="bottom"><img src="icecast.images/menu_button_playlists_selected.png" alt="Playlists" width="98" height="26" border="0" /></td>
          <td width="8"><img src="icecast.images/window_menu_bg_tabsep.png" width="8" height="30" /></td>
          <td width="98" valign="bottom"><a href="icecast.mainlog.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Button_MainLog','','icecast.images/menu_button_show_main_log_focus.png',1)"><img src="icecast.images/menu_button_show_main_log.png" alt="Show Main Log" name="Button_MainLog" width="98" height="30" border="0" id="Button_MainLog" /></a></td>
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
      <td height="541" align="center" valign="middle" background="icecast.images/window_content_bg.png"><table width="964" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="479" height="541" valign="top" background="icecast.images/content_left.png"><table width="479" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="23"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
              <td align="left"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td width="234"><img src="icecast.images/bigtab_playlist_generator.png" alt="Main settings" width="234" height="66" /></td>
                    <td align="right" valign="bottom"><a href="icecast.jump.php" target="invisible"><img src="icecast.images/button_jump_to_next.png" alt="Jump to next track" width="102" height="31" border="0" id="button_jump_to_next_focus" name="button_jump_to_next_focus" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('button_jump_to_next_focus','','icecast.images/button_jump_to_next_focus.png',1)" /></a></td>
                  </tr>
                </table><br />
                <img src="icecast.images/spacer.gif" width="1" height="9" />
                <table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="2" height="2"><img src="icecast.images/box_border_tl.png" width="2" height="2" /></td>
                            <td height="2" background="icecast.images/box_border_t.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                            <td width="2" height="2"><img src="icecast.images/box_border_tr.png" width="2" height="2" /></td>
                          </tr>
                          <tr>
                            <td width="2" background="icecast.images/box_border_ml.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                            <td width="433" height="190" bgcolor="#c8ccd2" class="t12b"><iframe src="icecast.browser.php" width="433" height="378" class="browser" name="browser"></iframe></td>
                            <td width="2" background="icecast.images/box_border_mr.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                          </tr>
                          <tr>
                            <td width="2" height="2"><img src="icecast.images/box_border_bl.png" width="2" height="2" /></td>
                            <td height="2" background="icecast.images/box_border_b.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                            <td width="2" height="2"><img src="icecast.images/box_border_br.png" width="2" height="2" /></td>
                          </tr>
                        </table>
                        <img src="icecast.images/spacer.gif" alt=" " width="1" height="5" /><br />Choose music file or directory to scan and click blue arrow button. MP3 files will be added to the list “On-The-Go”.
                </td>
              <td width="14"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
            </tr>
          </table></td>
          <td width="7" background="icecast.images/content_sep.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
          <td width="478" valign="top" background="icecast.images/content_right.png"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="21">&nbsp;</td>
              <td align="left"><table width="437" border="0" cellpadding="0" cellspacing="0"><tr>
                <td align="left">
                <img src="icecast.images/spacer.gif" width="1" height="28" /><br />
                <table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="2" height="2"><img src="icecast.images/box_border_tl.png" width="2" height="2" /></td>
                            <td height="2" background="icecast.images/box_border_t.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                            <td width="2" height="2"><img src="icecast.images/box_border_tr.png" width="2" height="2" /></td>
                          </tr>
                          <tr>
                            <td width="2" background="icecast.images/box_border_ml.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                            <td width="433" height="190" bgcolor="#c8ccd2" class="t12b"><iframe src="icecast.playlist.php" width="433" height="482" class="playlist" name="playlist"></iframe></td>
                            <td width="2" background="icecast.images/box_border_mr.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                          </tr>
                          <tr>
                            <td width="2" height="2"><img src="icecast.images/box_border_bl.png" width="2" height="2" /></td>
                            <td height="2" background="icecast.images/box_border_b.png"><img src="icecast.images/spacer.gif" width="1" height="1" /></td>
                            <td width="2" height="2"><img src="icecast.images/box_border_br.png" width="2" height="2" /></td>
                          </tr>
                        </table></td>
                </tr></table></td>
            </tr>
          </table></td>
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
          <td height="19" colspan="5"><img src="icecast.images/spacer.gif" width="1" height="1" /><iframe src="" width="1" height="1" class="invisible" name="invisible"></iframe></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
</body>
</html>
