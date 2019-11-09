$(document).ready(function(){
});

function basePlaylistAction()
{
    var currAction = $('#playlist-actions').val();

    if( currAction !== 'null') {
        switch ( currAction ) {
            case 'create': createNewPlaylist();
                           break;
            case 'delete': deleteCurrentPlaylist();
                           break;
            case 'clear' : clearCurrentList();
                           break;
        }
    }

    $("#playlist-actions option:selected").prop("selected", false);
    $("#playlist-actions option:first").prop("selected", "selected");
}

function getAllCurrentFiles()
{
    var currSongs = [];
    $('#playlist-table tbody td.playlist-file').each(function(){
        var thisFile = $(this).html();
        currSongs.push(thisFile);
    });
}

function loadSelectedPlaylist()
{
    $.ajax({
        'method': 'POST',
        'url'   : baseurl + '/ajax_loadselectedlist.php',
        'cache' : false,
        'data'  : {
            'selectList': $('#playlist-selector').val()
        },
        'beforeSend': function() {
            $('#playlist-table tbody').html('');
        }
    })
    .done(function( data, textStatus, jqXHR ) {
        if ( data.length ) {
            var result = $.parseJSON(data);

            $('#playlist-table tbody').html(result.message);
        }
    })
    .fail(function( jqXHR, textStatus ) {
        alert( str_ajax_failed + ": " + textStatus );
    });
}

function createNewPlaylist()
{
    // Clear Current Playlist
    $('#playlist-table tbody').html('');
    $('#playlist-selector option:selected').remove();

    // Drop-Down for Playlist reset
    $("#playlist-selector option:selected").prop("selected", false);
    $("#playlist-selector option:first").prop("selected", "selected");
}

function deleteCurrentPlaylist()
{
    $.ajax({
        'method': 'POST',
        'url'   : baseurl + '/ajax_deletecurrentlist.php',
        'cache' : false,
        'data'  : {
            'selectList': $('#playlist-selector').val()
        },
        'beforeSend': function() {
        }
    })
    .done(function( data, textStatus, jqXHR ) {
        var result = $.parseJSON(data);

        if ( result.error == true ) {
            alert( result.code );
        }
        else {
            // Request success

            if ( result.message.reset == true ) {
                $('#playlist-table tbody').html('');
                $('#playlist-selector option:selected').remove();

                // Drop-Down for Playlist reset
                $("#playlist-selector option:selected").prop("selected", false);
                $("#playlist-selector option:first").prop("selected", "selected");
            }
        }
    })
    .fail(function( jqXHR, textStatus ) {
        alert( str_ajax_failed + ": " + textStatus );
    });
}

function clearCurrentList()
{
    $.ajax({
        'method': 'POST',
        'url'   : baseurl + '/ajax_clearcurrentlist.php',
        'cache' : false,
        'data'  : {
            'selectList': $('#playlist-selector').val()
        },
        'beforeSend': function() {
        }
    })
    .done(function( data, textStatus, jqXHR ) {
        var result = $.parseJSON(data);

        if ( result.error == true ) {
            alert( result.code );
        }
        else {
            // Request success

            $('#playlist-table tbody').html('');
        }
    })
    .fail(function( jqXHR, textStatus ) {
        alert( str_ajax_failed + ": " + textStatus );
    });
}

function removeFile(fileID)
{
    $.ajax({
        'method': 'POST',
        'url'   : baseurl + '/ajax_removefile.php',
        'cache' : false,
        'data'  : {
            'fileID'    : fileID,
            'selectList': $('#playlist-selector').val()
        },
        'beforeSend': function() {
        }
    })
    .done(function( data, textStatus, jqXHR ) {
        var result = $.parseJSON(data);

        if ( result.error == true ) {
            alert( result.code );
        }
        else {
            // Request success

            $('#playlist-file-' + fileID).remove();
        }
    })
    .fail(function( jqXHR, textStatus ) {
        alert( str_ajax_failed + ": " + textStatus );
    });
}

function moveFile(fileID, direction)
{
    $.ajax({
        'method': 'POST',
        'url'   : baseurl + '/ajax_switchfile.php',
        'cache' : false,
        'data'  : {
            'fileID'    : fileID,
            'direction' : direction,
            'selectList': $('#playlist-selector').val()
        },
        'beforeSend': function() {
        }
    })
    .done(function( data, textStatus, jqXHR ) {
        var result = $.parseJSON(data);

        if ( result.error == true ) {
            alert( result.code );
        }
        else {
            // Request success

            $('#filepath-' + result.message.first).html(result.message.file1);
            $('#filepath-' + result.message.secound).html(result.message.file2);
        }
    })
    .fail(function( jqXHR, textStatus ) {
        alert( str_ajax_failed + ": " + textStatus );
    });
}