#!/bin/sh

source "./local-path.config"

# Set path where are stored all required libraries
export LD_LIBRARY_PATH="${QPKG_BASE}/lib"

# Start Icecast daemon with specified config file into background
${QPKG_BASE}/bin/icecast -b -c ${ICECASTXML} &