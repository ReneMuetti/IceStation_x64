function saveServerSettings()
{
    $.ajax({
        'method': 'POST',
        'url'   : baseurl + '/ajax_saveserversettings.php',
        'cache' : false,
        'data'  : {
            'port'         : $('#icecast-port').val(),
            'password'     : $('#icecast-password').val(),
            'restartIces0' : $('#restart-ices0').prop('checked'),
            'randomIces0'  : $('#random-ices0').prop('checked'),
            'nameIces0'    : $('#ices0-name').val(),
            'genreIces0'   : $('#ices0-genre').val(),
            'descrIces0'   : $('#ices0-descr').val(),
            'urlIces0'     : $('#ices0-url').val(),
            'publicIces0'  : $('#shoutcast-public').prop('checked'),
            'recodeIces0'  : $('#enable-recode').prop('checked'),
            'bitrateIces0' : $('#ices0-bitrate').val(),
            'channelsIces0': $('#ices0-channels').val()

        },
        'beforeSend': function() {}
    })
    .done(function( data, textStatus, jqXHR ) {
        var result = $.parseJSON(data);

        if ( result.error === true ) {
            alert( result.code );
        }
        else {
            // Request success

            window.location.reload();
        }
    })
    .fail(function( jqXHR, textStatus ) {
        alert( str_ajax_failed + ": " + textStatus );
    });
}