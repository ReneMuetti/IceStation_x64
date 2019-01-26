<?php
class Skins
{
    private $registry = null;
    private $skinlist = array();

    /**
     * Class Constructor
     *
     * @access    public
     */
    public function __construct()
    {
        global $site;

        $this -> registry = $site;

        $this -> _getSkinList();
    }

    /**
     * Class Finished
     *
     * @access    public
     */
    public function __destruct()
    {
        unset($this -> registry);
    }

    public function getSkins()
    {
        return $this -> skinlist;
    }

    public function getSkinOptions($selected = '')
    {
        $output = array();

        foreach( $this -> skinlist AS $value ) {
            $select = '';

            if ( $value == $selected ) {
                $select = ' selected="select"';
            }

            $output[] = '<option value="' . $value . '"' . $select . '>' . $value . '</option>';
        }

        return implode("", $output);
    }

    public function getSkinJson()
    {
        return json_encode($this -> skinlist);
    }


    private function _getSkinList()
    {
        $this -> skinlist = array();
        $this -> skinlist = glob($this -> registry -> config['templates'] . '/*' , GLOB_ONLYDIR);

        foreach( $this -> skinlist AS $key => $value ) {
            $this -> skinlist[$key] = basename($value);
        }
    }
}