function saveIcestationSettings()
{
    $.ajax({
        'method': 'POST',
        'url'   : baseurl + '/ajax_saveicecastsettings.php',
        'cache' : false,
        'data'  : {
            'skin'      : $('#icestation-skin').val(),
            'language'  : $('#icestation-language').val(),
            'charset'   : $('#icestation-charset').val(),
            'isocharset': $('#icestation-iso-charset').val(),
            'mediaext'  : $('#icestation-media-ext').val()
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