#!/bin/sh

source "./local-path.config"

DORUNICES="`/bin/cat ${ICESSTART}`"

# Set path where are stored all required libraries
export LD_LIBRARY_PATH="${QPKG_BASE}/lib"

# Start Icecast daemon with specified config file into background
if [ $DORUNICES = 1 ]; then

    if [ -f ${ICES2CONF} ]; then
        ${QPKG_BASE}/bin/ices2/ices ${ICES2CONF} &
    else
        echo "Fail to load Ices2-Conf... "
    fi
fi