#!/bin/sh

source "./local-path.config"

RETVAL=0

ICESSELECTED="`/bin/cat ${ICESPLAYSELECT}`"

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
	    [ -d "${publicdirp1}/${publicdirp2}/Public" ] && QPKG_BASE="${publicdirp1}/${publicdirp2}"
    fi
fi

if [ -z $QPKG_BASE ] ; then
    echo "The Public share not found."
    _exit 1
fi


case "$1" in
  start)

	echo "Starting IceStation server..."

	# check if IceStation should start or not
	if [ `/sbin/getcfg IceStation Enable -u -d FALSE -f /etc/config/qpkg.conf` = UNKNOWN ]; then
	    /sbin/setcfg IceStation Enable TRUE -f /etc/config/qpkg.conf
	elif [ `/sbin/getcfg IceStation Enable -u -d FALSE -f /etc/config/qpkg.conf` != TRUE ]; then
	    echo "IceStation is disabled."
	    exit 1
	fi

	# prepare short link for QPKG
	/usr/bin/readlink /${INSTALLDIR} | /bin/grep "${QPKG_BASE}/.qpkg/icestation"
	if [ $? != 0 ]; then
		/bin/rm -rf ${INSTALLDIR}
		/bin/ln -sf ${QPKG_BASE}/.qpkg/icestation ${INSTALLDIR}
	fi
	/bin/chmod 777 ${QPKG_BASE}/.qpkg/icestation
	/bin/chmod 777 ${INSTALLDIR}


	# prepare short link for root config
	/usr/bin/readlink /root/.icestation | /bin/grep "${QPKG_BASE}/.qpkg/icestation/root/.icestation"
	if [ $? != 0 ]; then
		/bin/rm -rf /root/.icestation
		/bin/ln -sf ${QPKG_BASE}/.qpkg/icestation/root/.icestation /root/.icestation
	fi
	/bin/chmod 777 ${QPKG_BASE}/.qpkg/icestation/root/.icestation
	/bin/chmod 777 /root/.icestation


	# remove old IceCast logs before start
	if [ -f "${QPKG_BASE}/var/log/icecast/access.log" ]; then
		/bin/rm -f ${QPKG_BASE}/var/log/icecast/*.log
	fi

	# remove old Icecast logs before start
	if [ -f "${QPKG_BASE}/var/log/ices0/ices.log" ]; then
		/bin/rm -f ${QPKG_BASE}/var/log/ices0/*.log
	fi

	echo "Starting Ices0 daemon... "
	[ -f "/usr/lib/locale/locale-archive" ] || /usr/bin/localedef -i en_US -f UTF-8 en_US.UTF-8

    #export LANG
	LANGVAR=`/usr/bin/locale | grep LANG | cut -f 2 -d "="`
	[ "x${LANGVAR}" != x ] || export LANG=en_US.UTF-8
	export HOME=/root
	export TERM=xterm
	export SHELL=/bin/sh
	export USER=admin
	export PWD=/root
	export EDITOR=/bin/vi
	export LOGNAME=admin

	# creating required directories for sudo
	if [ ! -d "/opt" ]; then
	    /bin/mkdir /opt
	fi
	if [ ! -d "/opt/etc" ]; then
	    /bin/mkdir /opt/etc
	fi
	# copying sudoers if not exist
	if [ ! -f "/opt/etc/sudoers" ]; then
	    /bin/cp -f ${QPKG_BASE}/opt/etc/sudoers /opt/etc
	fi

	# creating required directories for logs, pid file and cache file
	if [ ! -d "${QPKG_BASE}/var" ]; then
	    /bin/mkdir ${QPKG_BASE}/var
	fi
	if [ ! -d "${QPKG_BASE}/var/log" ]; then
	    /bin/mkdir ${QPKG_BASE}/var/log
	fi
	if [ ! -d "${QPKG_BASE}/var/log/ices0" ]; then
	    /bin/mkdir ${QPKG_BASE}/var/log/ices0
	fi
	if [ ! -d "${QPKG_BASE}/var/log/icecast" ]; then
	    /bin/mkdir ${QPKG_BASE}/var/log/icecast
	fi

	# adding special permissions for Ices0 logs directory
	/bin/chmod 777 ${QPKG_BASE}/var/log/ices0
	/bin/chmod 777 ${QPKG_BASE}/var/log/icecast

	# copying playlist
    /bin/cp -f "${WEB_DIR}/icestation/${ICESSELECTED}" "${ICESPLAYLIST}"

	# starting Icecast
	/bin/adduser -D icecast >/dev/null

	/bin/sudo -u admin ${ICECAST}

	/bin/chmod 666 ${ICECASTXML}

	/bin/sleep 3

	${ICES0}

	# set permission for config file to be sure it will be still editable next time by WebGUI
	/bin/chmod 666 ${ICESCONF}

	RETVAL=$?
	/bin/sleep 5


	if ps | grep -v grep | grep $SERVICE > /dev/null
	then
	    echo "$SERVICE service running, everything is fine"
	else
	    echo "$SERVICE is not running, starting it into background"
	    ${INSTALLDIR}/${SERVICE} 1> /dev/null 2> /dev/null &
	fi

	;;
  stop)

	echo "[1/3] Shutting down IceStation server..."

	echo "[2/3] Shutting down Ices0... "
	if [ -f $ICESPID ]; then
		/bin/kill `/bin/cat $ICESPID`
		/bin/rm -f $ICESPID
		RETVAL=$?
	else
		/bin/pidof ices 1>>/dev/null 2>>/dev/null
		if [ $? = 0 ]; then
			[ -f /sbin/killall ] || /bin/ln -sf /bin/busybox /sbin/killall
			/sbin/killall ices
			RETVAL=$?
		fi
	fi

	echo "[3/3] Shutting down Icecast... "
	if [ -f $ICEPID ]; then
		/bin/kill `/bin/cat $ICEPID`
		/bin/rm -f $ICEPID
		RETVAL=$?
	else
		/bin/pidof icecast 1>>/dev/null 2>>/dev/null
		if [ $? = 0 ]; then
			[ -f /sbin/killall ] || /bin/ln -sf /bin/busybox /sbin/killall
			/sbin/killall icecast
			RETVAL=$?
		fi
	fi
	/bin/deluser icecast >/dev/null
	/bin/delgroup icecast >/dev/null

	RETVAL=$?
	/bin/sleep 3
	;;
  restart)
	$0 stop
	$0 start
	RETVAL=$?
	;;
  *)
	echo "Usage: $0 {start|stop|restart}"
	exit 1
esac

exit $RETVAL
