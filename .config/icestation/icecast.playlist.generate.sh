#!/bin/sh

RETVAL=0
PLAYLIST="/share/Web/.config/icestation/icecast.playlist.txt"
LOCATION="`cat /share/Web/.config/icestation/icecast.path.conf`"

# creating playlist before
find ${LOCATION} -name *.mp3 > ${PLAYLIST}

exit $RETVAL

