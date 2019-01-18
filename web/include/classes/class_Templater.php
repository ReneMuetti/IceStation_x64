<?php
class Templater
{
    private $registry = null

    public function __construct()
    {
        global $site;

        $this -> registry = $site;
    }

    public function __destruct()
    {
    }

    public function loadTemplate($templateName = '')
    {
        $full_path = $this -> registry['config']['templates'];
    }
}
?>