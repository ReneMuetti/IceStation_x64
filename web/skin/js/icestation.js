$(document).ready(function(){
    $('span.checkbox-image').on('click', function(){
        $(this).next('label').click();
    });

    if ( $('#relay-table').length ) {
        getAllRelayServersToTable();
    }
});

function addNewRelayServer()
{
    $.ajax({
        'method': 'POST',
        'url'   : baseurl + '/ajax_addrelayserver.php',
        'cache' : false,
        'data'  : {
            'name'  : $('#new-server-name').val(),
            'port'  : $('#new-server-port').val(),
            'mount' : $('#new-server-mount').val(),
            'demand': $('#on-demand').prop('checked'),
            'meta'  : $('#meta-data').prop('checked')
        },
        'beforeSend': function() {}
    })
    .done(function( data, textStatus, jqXHR ) {
        var result = $.parseJSON(data);

        if ( result.error == true ) {
            alert( result.code );
        }
        else {
            // Request success
            //alert(result.message);
        }
    })
    .fail(function( jqXHR, textStatus ) {
        alert( str_ajax_failed + ": " + textStatus );
    });
}

function getAllRelayServersToTable()
{
    $.ajax({
        'method': 'POST',
        'url'   : baseurl + '/ajax_getrelayserver.php',
        'cache' : false,
        'data'  : {},
        'beforeSend': function() {}
    })
    .done(function( data, textStatus, jqXHR ) {
        var result = $.parseJSON(data);

        if ( result.error == true ) {
            alert( result.code );
        }
        else {
            // Request success
        }
    })
    .fail(function( jqXHR, textStatus ) {
        alert( str_ajax_failed + ": " + textStatus );
    });
}