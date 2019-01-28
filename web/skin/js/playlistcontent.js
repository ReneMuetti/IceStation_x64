$(document).ready(function(){
});

function removeFile(fileID)
{}

function moveFile(fileID, direction)
{
    $.ajax({
        'method': 'POST',
        'url'   : baseurl + '/ajax_switchfile.php',
        'cache' : false,
        'data'  : {
            'fileID'   : fileID,
            'direction': direction
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