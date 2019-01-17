<?php

function restart_icestation() {

  exec ("/etc/init.d/icestation.sh");
  
}
 
function generate_configs() {

  include ("icecast.includes.php");
  include ("icecast.relay.includes.php");
  include ("icecast.playlist.includes.php");

# save icecast config
    $File = "/root/.icestation/icecast.xml"; 
    $Handle = fopen($File, 'w');
    $Data1 = '<icecast>
    <limits>
        <clients>100</clients>
        <sources>5</sources>
        <threadpool>5</threadpool>
        <queue-size>524288</queue-size>
        <client-timeout>30</client-timeout>
        <header-timeout>15</header-timeout>
        <source-timeout>10</source-timeout>
        <burst-on-connect>1</burst-on-connect>
        <burst-size>65535</burst-size>
    </limits>

    <authentication>
        <source-password>' . $password . '</source-password>
        <relay-password>' . $password . '</relay-password>

        <admin-user>admin</admin-user>
        <admin-password>' . $password . '</admin-password>
    </authentication>

    <hostname>localhost</hostname>

    <listen-socket>
        <port>' . $port . '</port>
        <shoutcast-mount>/stream</shoutcast-mount>
    </listen-socket>
    ';
	
	$Data_Relay = '';

	if ($relay != "") {

      $relays = explode('#', $relay);
      $n = 0;
      foreach ($relays as &$value) {
        $n = $n + 1;
        $drelays = explode('|', $value);
        $Data_Relay = $Data_Relay . '
    <relay>
        <server>' . $drelays[0] .'</server>
        <port>' . $drelays[1] .'</port>
        <mount>' . $drelays[2] .'</mount>
        <local-mount>' . $drelays[3] .'</local-mount>
        <on-demand>' . $drelays[4] .'</on-demand>
        <relay-shoutcast-metadata>' . $drelays[5] .'</relay-shoutcast-metadata>
    </relay>
';
#	    foreach ($drelays as &$dvalue) {
#          echo '<td align="left" valign="middle" bgcolor="#bec2c7">' . $dvalue . '</td>';
#        }
      }
    
	}

	$Data2 = '
    <fileserve>1</fileserve>

    <paths>
        <basedir>/</basedir>
        <logdir>/usr/bin/icestation/var/log/icecast</logdir>
        <webroot>/usr/bin/icestation/share/icecast/web</webroot>
        <adminroot>/usr/bin/icestation/share/icecast/admin</adminroot>
        <pidfile>/usr/bin/icestation/share/icecast/icecast.pid</pidfile>

        <alias source="/" dest="/status.xsl"/>
    </paths>

    <logging>
        <accesslog>access.log</accesslog>
        <errorlog>error.log</errorlog>
      	<loglevel>3</loglevel> <!-- 4 Debug, 3 Info, 2 Warn, 1 Error -->
      	<logsize>10000</logsize> <!-- Max size of a logfile -->
    </logging>

    <security>
        <chroot>0</chroot>
        <changeowner>
            <user>icecast</user>
            <group>icecast</group>
        </changeowner>
    </security>
</icecast>
';
	$Data = $Data1 . $Data_Relay . $Data2; 
 
	fwrite($Handle, $Data); 
	fclose($Handle); 

# save ices0 config
    $File = "/root/.icestation/ices0.conf"; 
    $Handle = fopen($File, 'w');
    $Data = '<?xml version="1.0"?>
<ices:Configuration xmlns:ices="http://www.icecast.org/projects/ices">
  <Playlist>
    <File>/share/Qweb/.config/icestation/icecast.playlist.txt</File>
    <Randomize>' . $randomize .'</Randomize>
    <Type>builtin</Type>
    <Module>ices</Module>
  </Playlist>

  <Execution>
    <Background>1</Background>
    <Verbose>0</Verbose>
    <BaseDirectory>/usr/bin/icestation/var/log/ices0</BaseDirectory>
  </Execution>

  <Stream>
    <Server>
      <Hostname>127.0.0.1</Hostname>
      <Port>' . $port .'</Port>
      <Password>' . $password .'</Password>
      <Protocol>http</Protocol>
    </Server>

    <Mountpoint>/stream</Mountpoint>

    <Name>' . $name . '</Name>
    <Genre>' . $genre . '</Genre>
    <Description>' . $description . '</Description>
    <URL>' . $URL . '</URL>

    <Public>' . $public . '</Public>

    <Bitrate>' . $bitrate . '</Bitrate>
    <Reencode>' . $reencode . '</Reencode>
    <Channels>' . $channels . '</Channels>
  </Stream>
</ices:Configuration>';
 
	fwrite($Handle, $Data); 
	fclose($Handle); 
}

?>