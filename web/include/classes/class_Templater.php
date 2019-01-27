<?php
class Templater
{
    private $registry = null;
    private $vars = array();

    private $template;

    /**
     * Class Constructor
     *
     * @access    public
     */
    public function __construct()
    {
        global $site;

        $this -> registry = $site;

        $this -> _fetch_local_vars();
        $this -> _fetch_language();
        $this -> _fetch_icecast();
        $this -> _fetch_ices0();
        $this -> _fetch_ices2();
    }

    /**
     * Class Finished
     *
     * @access    public
     */
    public function __destruct()
    {
        unset($this -> template, $this -> vars, $this -> registry);
    }

    /**
     * Add Variable for Rendering
     *
     * @access    public
     * @param     string         Key for Creation
     * @param     string         Value for Key
     */
    public function setVariable($key = null, $value = null)
    {
        if ( strlen($key) ) {
            $this -> vars['<var ' . $key . ' />'] = $value;
        }
    }

    /**
     * loading Template from Template-File
     *
     * @access    public
     * @param     string         Name from Template
     * @param     bool           Save Content in Variable or direct return
     * @return    none|string
     */
    public function loadTemplate($templateName = '', $saveForRendering = true)
    {
        $full_path = $this -> registry -> config['templates'] . '/' . $this -> registry -> user_config['skin'] . '/' . $templateName;

        // File not found => search in "Default"
        if ( !is_file($full_path) ) {
            if ( $this -> registry -> user_config['skin'] != 'default' ) {
                $full_path = $this -> registry -> config['templates'] . '/default/' . $templateName;
            }
        }

        // File not found => raise Error
        if ( !is_file($full_path) ) {
            throw new Exception( 'Datei ' . $templateName . ' wurde nicht gefunden!' );
        }

        if ($saveForRendering) {
            $this -> template = file_get_contents($full_path);
            $this -> template = str_replace('', '', $this -> template);
        }
        else {
            return file_get_contents($full_path);
        }
    }

    /**
     * Replate all Variable-Keys in Template
     *
     * @access    public
     * @return    string
     */
    public function renderTemplate()
    {
        return str_replace(
                   array_keys($this -> vars),
                   array_values($this -> vars),
                   $this -> template
               );
    }

    /**
     * Append Debug-Output to MainPage
     *
     * @access    public
     * @param     mixed          Variable for Output
     */
    public function renderDebugOutput($debugVar = null)
    {
        if ( !is_null($debugVar) ) {
            if ( !is_string($debugVar) ) {
                $debugVar = print_r($debugVar, true);
            }
            $this -> vars['<var before_finished />'] = $this -> _addDebugOutput( $debugVar );
        }
    }

    /**
     * Check if a User-Option is set
     *
     * @access    public
     * @param     string|bool    Section in Registry; If FALSE then if Key a concrete Value
     * @param     string         Key in Registry
     * @return    string
     */
    public function getCheckboxState($section = null, $key = null)
    {
        if ( is_null($section) OR is_null($key) ) {
            return 'Section-Key-ERROR!';
        }
        else {
            if ( is_string($section) ) {
                if ( isset($this -> registry -> $section) ) {
                    $tmp = $this -> registry -> $section;
                    if ( isset($tmp[$key]) ) {
                        if ( $tmp[$key] == true ) {
                            return ' checked="checked"';
                        }
                        else {
                            return '';
                        }
                    }
                    else {
                        return 'Key not exists!';
                    }
                }
                else {
                    return 'Section not exists!';
                }
            }
            else {
                if ( is_null($key) ) {
                    return 'Key not set!';
                }
                else {
                    if ( $key == true ) {
                        return ' checked="checked"';
                    }
                    else {
                        return '';
                    }
                }
            }
        }
    }

    /*************************************************************************************/
    /********************************  Private Functions  ********************************/
    /*************************************************************************************/

    /**
     * rendering Debug-Output
     *
     * @access    private
     * @param     string         Content from Variable
     * @return    string
     */
    private function _addDebugOutput($debugVar = null)
    {
        $debugVar = htmlentities(trim($debugVar), ENT_QUOTES | ENT_XHTML | ENT_IGNORE, "UTF-8");

        return str_replace(
                   '<var debug_out />',
                   str_replace('=&amp;gt;', '=&gt;', $debugVar),
                   $this -> loadTemplate('debug.htm', false)
               );
    }

    /**
     * add local Vars for Rendering
     *
     * @access    private
     */
    private function _fetch_local_vars()
    {
        $this -> vars['<var before_finished />'] = '';

        $this -> vars['<var_config host />']         = $this -> registry -> config['host'];
        $this -> vars['<var_config protocol />']     = $this -> registry -> config['protocol'];
        $this -> vars['<var_config script />']       = $this -> registry -> config['script'];
        $this -> vars['<var_config baseurl />']      = $this -> registry -> config['baseurl'];
        $this -> vars['<var_config server_addr />']  = $this -> registry -> config['server_addr'];
        $this -> vars['<var_config server_name />']  = $this -> registry -> config['server_name'];
        $this -> vars['<var_config server_port />']  = $this -> registry -> config['server_port'];
        $this -> vars['<var_config gui_version />']  = file_get_contents($this -> registry -> config['inc_path'] . '/version.txt');

        foreach( $this -> registry -> user_config AS $key => $value ) {
            $this -> vars['<var_user_config ' . $key . ' />'] = $value;
        }
    }

    /**
     * add Language for Rendering
     *
     * @access    private
     */
    private function _fetch_language()
    {
        foreach( $this -> registry -> user_lang AS $section => $data ) {
            if ( is_array($data) ) {
                foreach( $data AS $key => $value ) {
                    $this -> vars['<lang ' . $section . '_' . $key . ' />'] = output_string($value);
                }
            }
            else {
                $this -> vars['<lang ' . $section . ' />'] = output_string($data);
            }
        }
    }

    /**
     * add Settings from Icecast for Rendering
     *
     * @access    private
     */
    private function _fetch_icecast()
    {
        $this -> vars['<var_icecast mount />']   = $this -> registry -> icecast['listen-socket']['shoutcast-mount'];
        $this -> vars['<var_icecast server />']  = $this -> registry -> icecast['server-id'];
        $this -> vars['<var_icecast version />'] = substr($this -> registry -> icecast['server-id'], 8 );
        $this -> vars['<var_icecast status />']  = $this -> registry -> icecast['paths']['alias']['dest'];
        $this -> vars['<var_icecast port />']    = $this -> registry -> icecast['listen-socket']['port'];
    }

    /**
     * add Settings from Icecs0 for Rendering
     *
     * @access    private
     */
    private function _fetch_ices0()
    {
        $this -> vars['<var_ices0 port />']   = $this -> registry -> ices0['Stream']['Server']['Port'];
        $this -> vars['<var_ices0 mount />']  = $this -> registry -> ices0['Stream']['Mountpoint'];
    }

    /**
     * add Settings from Ices2 for Rendering
     *
     * @access    private
     */
    private function _fetch_ices2()
    {
        $this -> vars['<var_ices2 port />']      = $this -> registry -> ices2['instance']['port'];
        $this -> vars['<var_ices2 mount />']     = $this -> registry -> ices2['instance']['mount'];
        $this -> vars['<var_ices2 name />']      = $this -> registry -> ices2['metadata']['name'];
        $this -> vars['<var_ices2 genre />']     = $this -> registry -> ices2['metadata']['genre'];
        $this -> vars['<var_ices2 desc />']      = $this -> registry -> ices2['metadata']['description'];
        $this -> vars['<var_ices2 bitrate />']   = $this -> registry -> ices2['instance']['encode']['nominal-bitrate'];
        $this -> vars['<var_ices2 channels />']  = $this -> registry -> ices2['instance']['encode']['channels'];
    }
}
?>