<?php
class DirectoryLister
{
    private $registry   = null;
    private $selectPath = null;
    private $tmpDir     = null;
    private $cut        = null;

    private $showParentDir  = true;
    private $currentContent = array();
    private $mediaExtends   = array();

    public function __construct( $initDir = null )
    {
        global $site;

        $this -> registry = $site;

        $this -> mediaExtends = explode(',', $this -> registry -> user_config['media_extensions']);

        if ( !is_null($initDir) ) {
            $this -> setListingPath($initDir);
        }
    }

    public function __destruct()
    {
        unset($this -> registry, $this -> currentContent);
    }

    public function getLastTempDir()
    {
        return '|' . $this -> tmpDir . '|' . $this -> cut . '|';
    }

    public function setListingPath( $initDir = null )
    {
        $doubleSeperator = DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR;

        $this -> tmpDir = str_replace($doubleSeperator, DIRECTORY_SEPARATOR, $initDir);
        $this -> tmpDir = str_replace($this -> registry -> config['multimedia_root'], '', $this -> tmpDir);
        $this -> tmpDir = realpath($this -> registry -> config['multimedia_root'] . DIRECTORY_SEPARATOR . $this -> tmpDir);

        $this -> cut = str_replace($this -> registry -> config['multimedia_root'], '', $this -> tmpDir);

        if ( strlen($this -> cut) ) {
            $this -> showParentDir = true;
        }
        else {
            $this -> showParentDir = false;
        }

        if ( is_dir($this -> tmpDir) ) {
            $this -> selectPath = $this -> tmpDir;
        }
        else {
            $this -> selectPath = $this -> registry -> config['multimedia_root'];
        }
    }

    public function getCurrentDirectory()
    {
        $this -> _scanDirectory();

        $output = array();

        if ( count($this -> currentContent) ) {
            $renderer = new Templater();

            foreach( $this -> currentContent AS $key => $data ) {
                $ext = substr($data['name'], -3);

                if ( $data['name'] == '..' ) {
                    $renderer -> loadTemplate('playlist-directory-row-parent.htm');
                }
                elseif ( !in_array($ext, $this -> mediaExtends) AND ($data['type'] == 'file') ) {
                    $renderer -> loadTemplate('playlist-directory-row-nomultimedia.htm');
                }
                else {
                    $renderer -> loadTemplate('playlist-directory-row.htm');
                }

                $renderer -> setVariable('file_name', $data['name']);
                $renderer -> setVariable('file_type', $data['type']);
                $tempLine = $renderer -> renderTemplate();

                $renderer -> setTemplateString($tempLine);
                    $renderer -> setVariable('lang_playlist_file_info', output_string($this -> registry -> user_lang['playlist']['file_info'], true) );
                    $renderer -> setVariable('lang_playlist_dir_info' , output_string($this -> registry -> user_lang['playlist']['dir_info'], true) );
                $output[] = $renderer -> renderTemplate();
            }
        }

        return implode("\n", $output);
    }


    private function _scanDirectory()
    {
        $this -> currentContent = array();

        $handle = opendir( $this -> selectPath );
        while( ($file = readdir($handle)) !== false ) {
            if ( $file == '.' ) {
                continue;
            }
            if ( $file == '..' AND !$this -> showParentDir ) {
                continue;
            }

            $filepath = ( $this -> selectPath . DIRECTORY_SEPARATOR . $file );
            if ( is_link($filepath) ) {
                continue;
            }
            if ( is_file($filepath) ) {
                $this -> currentContent[] = array(
                                                'name' => $file,
                                                'type' => 'file'
                                            );
            }
            if ( is_dir($filepath) ) {
                $this -> currentContent[] = array(
                                                'name' => $file,
                                                'type' => 'dir'
                                            );
            }
        }
    }
}

?>