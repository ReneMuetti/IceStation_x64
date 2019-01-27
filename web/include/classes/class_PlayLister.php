<?php
class PlayLister
{
    private $registry   = null;

    public function __construct( $initDir = null )
    {
        global $site;

        $this -> registry = $site;
    }

    public function __destruct()
    {
        unset($this -> registry);
    }

}
?>