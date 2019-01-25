$(document).ready(function(){
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
            var newServerData = {
                    'internal': result.message,
                    'name'    : $('#new-server-name').val(),
                    'port'    : $('#new-server-port').val(),
                    'mount'   : $('#new-server-mount').val(),
                    'demand'  : $('#on-demand').prop('checked'),
                    'meta'    : $('#meta-data').prop('checked')
                };
            addLineToRelayTable(newServerData);

            $('#new-server-name').val('');
            $('#new-server-port').val('');
            $('#new-server-mount').val('');
            $('#on-demand').prop('checked',false);
            $('#meta-data').prop('checked',false);
        }
    })
    .fail(function( jqXHR, textStatus ) {
        alert( str_ajax_failed + ": " + textStatus );
    });
}

function removeRelayServer(serverID)
{
    $.ajax({
        'method': 'POST',
        'url'   : baseurl + '/ajax_deleterelayserver.php',
        'cache' : false,
        'data'  : {
            'server' : serverID
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
            $('#server-' + serverID).remove();
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
        'beforeSend': function() {
            $('#relay-table tbody').html('');
        }
    })
    .done(function( data, textStatus, jqXHR ) {
        var result = $.parseJSON(data);

        if ( result.error == true ) {
            alert( result.code );
        }
        else {
            if ( result.count >= 1 ) {
                $(result.message).each(function(index, data) {
                     addLineToRelayTable(data);
                });
            }
            else {}
        }
    })
    .fail(function( jqXHR, textStatus ) {
        alert( str_ajax_failed + ": " + textStatus );
    });
}

function addLineToRelayTable(serverData)
{
    var cellDelete = $('<td />', {
            'html': getDelete(serverData.internal)
        });
    var cellAddress = $('<td />', {
            'html': serverData.name
        });
    var cellPort = $('<td />', {
            'html': serverData.port
        });
    var cellMount = $('<td />', {
            'html': '/' + serverData.mount
        });
    var cellLocal = $('<td />', {
            'html': getRelayPlayLink(serverData.internal)
        });
    var cellDemand = $('<td />', {
            'html': getOnOffImage(serverData.demand)
        });
    var cellMeta = $('<td />', {
            'html': getOnOffImage(serverData.meta)
        });

    var tableRow = $('<tr />', {
            'id': 'server-' + serverData.internal
        });

    tableRow.append(cellDelete).append(cellAddress).append(cellPort)
            .append(cellMount).append(cellLocal)
            .append(cellDemand).append(cellMeta);
    $('#relay-table tbody').append(tableRow);
}

function getDelete(serverId)
{
    var image = $('<img />', {
            'src'  : baseurl + '/skin/images/' + skin + '/relay_delete.png',
            'alt'  : str_relay_title_delete,
            'title': str_relay_title_delete
        });

    var link = $('<a />', {
            'href'   : 'javascript:void(0);',
            'title'  : str_relay_title_delete,
            'html'   : image,
            'onclick': 'removeRelayServer(' + serverId + ')',
        });
    return link;
}

function getRelayPlayLink(localMount)
{
    var link = $('<a />', {
                   'href': protokoll + '://' + station_server + ':' + station_port + '/' + localMount + '.m3u',
                   'html': '/' + localMount
               });
    return link;
}

function getOnOffImage(status)
{
    if ( status == true || status == '1' || status == 'on' || status == 'yes' ) {
        var imgName = 'online';
        var strStatus = str_status_yes;
    }
    else {
        var imgName = 'offline';
        var strStatus = str_status_no;
    }

    var image = $('<img />', {
            'src'  : baseurl + '/skin/images/status_' + imgName + '.gif',
            'alt'  : strStatus,
            'title': strStatus
        });
    return image;
}