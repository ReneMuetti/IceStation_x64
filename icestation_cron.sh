#!/bin/sh

source "./local-path.config"

# run while
while [ 1 == 1 ]; do
    if [ -f "${DEXEC}" ]; then
	    ${DEXEC}
    fi
    sleep 5
done

