#!/bin/sh
clear

# Name festlegen
PACKAGE_SYSTEM='Entware'

# SHARE-Path
SHARE='/share/CACHEDEV1_DATA/.qpkg'

# lokaler Pfad zur Optware
OPT_PATH=${SHARE}'/Entware-3x/bin'
ICE_PATH=${SHARE}'/icestation/bin'

# lokaler LIB-Pfad
OPT_LIB_PATH=${SHARE}'/Entware-3x/lib'
ICE_LIB_PATH=${SHARE}'/icestation/lib'
MEDIA_LIB='/mnt/ext/opt/medialibrary/bin'

# Installer deklarieren
OPT_INTS='opkg'

# lokale Tool--Pfad
LN_PATH='/bin/ln'
MV_PATH='/bin/mv'

# IceCast-Zusätze deklarieren
declare -a ICE_LIBS=("libvorbis libshout lame lame-lib curl libcurl idn libidn ices icecast xsltproc")

# zu verlinkende Libs deklarieren
declare -a LOC_LIBS=("libvorbis.so.0.4.8~libvorbis.so              libvorbis.so.0.4.8~libvorbis.so.0           libogg.so.0.8.3~libogg.so.0 \
                      libvorbisenc.so.2.0.11~libvorbisenc.so       libvorbisenc.so.2.0.11~libvorbisenc.so.2    libshout.so.3.2.0~libshout.so.3 \
                      libvorbisfile.so.3.3.7~libvorbisfile.so.3    libxslt.so.1.1.32~libexslt.so               libxml2.so.2.9.8~libxml2.so \
                      libvorbisfile.so.3.3.7~libvorbisfile.so      libxslt.so.1.1.32~libxslt.so                libmp3lame.so.0.0.0~libmp3lame.so.0 \
                      libmp3lame.so.0.0.0~libmp3lame.so            libogg.so.0.8.3~libogg.so                   libcurl.so.4.5.0~libcurl.so \
                      libcurl.so.4.5.0~libcurl.so.4                libxml2.so.2.9.8~libxml2.so.2               libidn.so.12.6.0~libidn.so.11 \
                      libidn.so.12.6.0~libidn.so                   libshout.so.3.2.0~libshout.so               libxslt.so.1.1.32~libxslt.so.1 \
                      libexslt.so.0.8.20~libexslt.so.0
                     ");


if [ -L /bin/${OPT_INTS} ]; then
    echo 'Link zu '${OPT_INTS}' vorhanden'
else
    echo 'erzeuge Link zu '${OPT_INTS}
    ${LN_PATH} -sf ${OPT_PATH}/${OPT_INTS} /bin/${OPT_INTS}
fi

if [ -d ${OPT_PATH} ]; then

    echo
    echo 'IceCast-Libs installieren...'
    for inst in ${ICE_LIBS}; do
        echo 'installiere '${inst}' ...'
        ${OPT_INTS} install ${inst}
    done

    echo
    echo 'Libs verlinken...'
    for tool in ${LOC_LIBS}; do
        QUELLE=$(echo ${tool} | cut -f1 -d"~")
        ZIEL=$(echo ${tool} | cut -f2 -d"~")

        if [ -L ${ICE_LIB_PATH}/${ZIEL} ]; then
            echo 'Link zu '${ZIEL}' vorhanden'
        else
            echo 'erzeuge Link zu '${ZIEL}
            ${LN_PATH} -sf ${OPT_LIB_PATH}/${QUELLE} ${ICE_LIB_PATH}/${ZIEL}
        fi
    done

    ## Binarys auf x64 umstellen
    cd ${ICE_PATH}

    echo
    echo 'x86-Files sichern...'
    ${MV_PATH} icecast icecast_x86
    ${MV_PATH} sudo sudo_x86
    ${MV_PATH} curl curl_x86
    ${MV_PATH} lame lame_x86
    ${MV_PATH} xsltproc xsltproc_x86
    ${MV_PATH} xmllint xmllint_x86
    ${MV_PATH} xmlcatalog xmlcatalog_x86
    ${MV_PATH} xml2-config xml2-config_x86

    echo
    echo ${PACKAGE_SYSTEM}' x64-Binarys verlinken...'
    ${LN_PATH} -sf ${OPT_PATH}/icecast icecast
    ${LN_PATH} -sf ${OPT_PATH}/sudo sudo
    ${LN_PATH} -sf ${OPT_PATH}/cur curl
    ${LN_PATH} -sf ${OPT_PATH}/lame lame
    ${LN_PATH} -sf ${OPT_PATH}/xsltproc xsltproc

    echo
    echo 'Media-Lib-Binarys verlinken ...'
    ${LN_PATH} -sf ${MEDIA_LIB}/xmllint xmllint
    ${LN_PATH} -sf ${MEDIA_LIB}/xmlcatalog xmlcatalog
    ${LN_PATH} -sf ${MEDIA_LIB}/xml2-config xml2-config

    echo
    echo 'ICES2-Verzeichniss erzeugen...'
    mkdir ices2

    echo
    echo 'ICES2 verlinken...'
    ${LN_PATH} -sf ${OPT_PATH}/ices ices2/ices

else
    echo 'Bitte erst '${PACKAGE_SYSTEM}' aus dem Web-Interface installieren!'
fi
