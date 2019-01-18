<?php
class Templater
{
    private $registry = null;
    private $vars = array();

    private $template = '';

    public function __construct()
    {
        global $site;

        $this -> registry = $site;

        $this -> _fetch_local_vars();
    }

    public function __destruct()
    {
    }

    public function loadTemplate($templateName = '', $saveForRendering = true)
    {
        $full_path = $this -> registry -> config['templates'] . '/' . $this -> registry -> user_config['skin'] . '/' . $templateName;

        if ( is_file($full_path) ) {
            if ($saveForRendering) {
                $this -> template = file_get_contents($full_path);
            }
            else {
                return file_get_contents($full_path);
            }
        }
    }

    public function renderTemplate()
    {
        return str_replace(
                   array_keys($this -> vars),
                   array_values($this -> vars),
                   $this -> template
               );
    }

    public function renderDebugOutput($debugVar = null)
    {
        if ( !is_null($debugVar) ) {
            if ( !is_string($debugVar) ) {
                $debugVar = print_r($debugVar, true);
            }
            $this -> vars['<var before_finished />'] = $this -> _addDebugOutput( $debugVar );
        }
    }

    private function _addDebugOutput($debugVar = null)
    {
        return str_replace(
                   '<var debug_out />',
                   trim($debugVar),
                   $this -> loadTemplate('debug.htm', false)
               );
    }

    private function _fetch_local_vars()
    {
        $this -> vars['<var before_finished />'] = '';

        $this -> vars['<var_config host />']     = $this -> registry -> config['host'];
        $this -> vars['<var_config protocol />'] = $this -> registry -> config['protocol'];
        $this -> vars['<var_config script />']   = $this -> registry -> config['script'];
        $this -> vars['<var_config baseurl />']  = $this -> registry -> config['baseurl'];

        foreach( $this -> registry -> user_config AS $key => $value ) {
            $this -> vars['<var_user_config ' . $key . ' />'] = $value;
        }
    }
}
?>