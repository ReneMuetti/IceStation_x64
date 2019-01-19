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

        if ( is_file($full_path) ) {
            if ($saveForRendering) {
                $this -> template = file_get_contents($full_path);
            }
            else {
                return file_get_contents($full_path);
            }
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
                    $this -> vars['<lang ' . $section . '_' . $key . ' />'] = $value;
                }
            }
            else {
                $this -> vars['<lang ' . $section . ' />'] = $value;
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
        $this -> vars['<var_icecast port />']   = $this -> registry -> icecast['listen-socket']['port'];
        $this -> vars['<var_icecast mount />']  = $this -> registry -> icecast['listen-socket']['shoutcast-mount'];
        $this -> vars['<var_icecast server />'] = $this -> registry -> icecast['server-id'];
        $this -> vars['<var_icecast status />'] = $this -> registry -> icecast['paths']['alias']['dest'];
    }

    /**
     * add Settings from Icecs0 for Rendering
     *
     * @access    private
     */
    private function _fetch_ices0()
    {
        $this -> vars['<var_ices2 port />']      = $this -> registry -> ices0['Stream']['Server']['Port'];
        $this -> vars['<var_ices0 mount />']     = $this -> registry -> ices0['Stream']['Mountpoint'];
        $this -> vars['<var_ices0 name />']      = $this -> registry -> ices0['Stream']['Name'];
        $this -> vars['<var_ices0 genre />']     = $this -> registry -> ices0['Stream']['Genre'];
        $this -> vars['<var_ices0 desc />']      = $this -> registry -> ices0['Stream']['Description'];
        $this -> vars['<var_ices0 url />']       = $this -> registry -> ices0['Stream']['URL'];
        $this -> vars['<var_ices0 public />']    = $this -> registry -> ices0['Stream']['Public'];
        $this -> vars['<var_ices0 bitrate />']   = $this -> registry -> ices0['Stream']['Bitrate'];
        $this -> vars['<var_ices0 recode />']    = $this -> registry -> ices0['Stream']['Reencode'];
        $this -> vars['<var_ices0 channels />']  = $this -> registry -> ices0['Stream']['Channels'];
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