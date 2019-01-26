<?php
class Language
{
    private $registry = null;
    private $langlist = array();

    /**
     * Class Constructor
     *
     * @access    public
     */
    public function __construct()
    {
        global $site;

        $this -> registry = $site;

        $this -> _getLangList();
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

    public function getLanguages()
    {
        return $this -> langlist;
    }

    public function getLangOptions($selected = '')
    {
        $output = array();

        foreach( $this -> langlist AS $value ) {
            $select = '';

            if ( $value == $selected ) {
                $select = ' selected="select"';
            }

            $output[] = '<option value="' . $value . '"' . $select . '>' . $value . '</option>';
        }

        return implode("", $output);
    }

    public function getLangJson()
    {
        return json_encode($this -> langlist);
    }


    private function _getLangList()
    {
        $this -> langlist = array();
        $this -> langlist = glob($this -> registry -> config['languages'] . '/*.xml');

        foreach( $this -> langlist AS $key => $value ) {
            $this -> langlist[$key] = substr( basename($value), 0, -4 );
        }
    }
}