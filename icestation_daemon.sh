#!/bin/sh

source "./local-path.config"

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



# check if IceStation is working or not
if [ `/sbin/getcfg IceStation Enable -u -d FALSE -f /etc/config/qpkg.conf` = UNKNOWN ]; then
    /sbin/setcfg IceStation Enable TRUE -f /etc/config/qpkg.conf
elif [ `/sbin/getcfg IceStation Enable -u -d FALSE -f /etc/config/qpkg.conf` != TRUE ]; then
    echo "IceStation is disabled."
    exit 1
fi

# check for SIGNAL file
if [ -f "${SIGNAL}" ]; then
    SIGNALMSG=`cat ${SIGNAL}`
    /bin/rm -f ${SIGNAL}

    # execute
    if [ -f "${SEXEC}" ]; then
	${SEXEC} ${SIGNALMSG}
    fi

    echo "${SIGNALMSG}" > ${SIGNALRET}
fi
