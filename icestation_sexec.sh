#!/bin/sh

source "./local-path.config"

# PID
ICESPID="`cat ${QPKG_BASE}/var/log/ices0/ices.pid`"


_exit()
{
    /bin/echo -e "Error: $*"
    /bin/echo
    exit 1
}

# Determine BASE installation location according to smb.conf
publicdir=`/sbin/getcfg Public path -f /etc/config/smb.conf`
if [ ! -z $publicdir ] && [ -d $publicdir ]; then
    publicdirp1=`/bin/echo $publicdir | /bin/cut -d "/" -f 2`
    publicdirp2=`/bin/echo $publicdir | /bin/cut -d "/" -f 3`
    publicdirp3=`/bin/echo $publicdir | /bin/cut -d "/" -f 4`
    if [ ! -z $publicdirp1 ] && [ ! -z $publicdirp2 ] && [ ! -z $publicdirp3 ]; then
	    [ -d "/${publicdirp1}/${publicdirp2}/Public" ] && QPKG_BASE="/${publicdirp1}/${publicdirp2}"
    fi
fi

if [ -z $QPKG_BASE ] ; then
    echo "The Public share not found."
    _exit 1
fi

case "$1" in
  restart)

	${ICESTATIONSCRIPT} restart
	;;

  jump)

	/bin/kill -USR1 ${ICESPID}
	;;

  *)
	echo "Usage: $0 {restart|jump}"
	exit 1
esac
