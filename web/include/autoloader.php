<?php
/**
 * automatic Classloader
 *
 * @access  public
 * @param   string       ClassName
 * @return  null|error
 */
spl_autoload_register( function ($classname) {
    if ( !class_exists($classname) AND strlen($classname) ) {
        $_classFile = CLASS_PATH . '/class_' . $classname . '.php';

        if ( is_file( $_classFile ) ) {
            require_once $_classFile;
        }
        else {
             trigger_error('Faild to load Class "' . $_classFile . '"', E_USER_ERROR);
        }
    }
    else {
        trigger_error('Empty Class-Name "' . $classname . '"', E_USER_ERROR);
    }
});

?>