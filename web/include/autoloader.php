<?php
/**
 * automatic Classloader
 *
 * @access  public
 * @param   string       ClassName
 * @return  null|error
 */
function __autoload($classname)
{
    $classname = trim($classname);

    if ( !class_exists($classname) AND strlen($classname) ) {
        $_classFile = CLASS_PATH . '/' . $classname . '.php';

        require_once $_classFile;
    }
    else {
        trigger_error('Faild to load Class "' . $classname . '"', E_USER_ERROR);
    }
}

?>