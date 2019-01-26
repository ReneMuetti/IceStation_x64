$(document).ready(function(){
});

function openDirectory(directory)
{
    $.ajax({
        'method': 'POST',
        'url'   : baseurl + '/ajax_opendirectory.php',
        'cache' : false,
        'data'  : {
            'directory': directory,
            'rootdir'  : $('#playlist-path').val()
        },
        'beforeSend': function() {
            $('#directory-table tbody').html('');
        }
    })
    .done(function( data, textStatus, jqXHR ) {
        var result = $.parseJSON(data);

        if ( result.error == true ) {
            alert( result.code );
        }
        else {
            // Request success
            $('#directory-table tbody').html(result.message);
            $('#playlist-path').val(result.newroot);
        }
    })
    .fail(function( jqXHR, textStatus ) {
        alert( str_ajax_failed + ": " + textStatus );
    });
}

function addToPlaylist(dirstring)
{
    alert(dirstring);
}