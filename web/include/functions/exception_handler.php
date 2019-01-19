<?php
set_error_handler('getError');
set_exception_handler('getException');

function getError()
{
    $error = error_get_last();
    getException( new ErrorException( $error["message"], 0, $error["type"], $error["file"], $error["line"] ) );
}

function getException( Exception $e )
{
    global $nvtracker, $jobname;

    $info =array();

    if ( !empty($jobname) )
    {
        $info[] = 'Job: '  . $jobname;
    }

    $info[] = 'Klasse: '  . get_class( $e );
    $info[] = 'Meldung: ' . $e -> getMessage();
    $info[] = 'Datei: '   . $e -> getFile();
    $info[] = 'Zeile: '   . $e -> getLine();
    $info[] = 'Stack-Trace:';
    $info[] = $e -> getTraceAsString();
    //$info[] = 'DEBUG-Trace:';
    //$info[] = print_r( debug_backtrace(), TRUE );

    $lineToWrite = implode("\n", $info);

    new Logging('exception', $lineToWrite);
}
?>