#!/bin/sh

source "./local-path.config"

DORUNICES="`/bin/cat ${ICESSTART}`"

# Set path where are stored all required libraries
export LD_LIBRARY_PATH="${QPKG_BASE}/lib"

# Start Icecast daemon with specified config file into background
if [ $DORUNICES = 1 ]; then

    if [ -f ${ICES0CONF} ]; then
        ${QPKG_BASE}/bin/ices0/ices -c ${ICES0CONF} &
    else
        echo "Fail to load Ices0-Conf... "
    fi
fi