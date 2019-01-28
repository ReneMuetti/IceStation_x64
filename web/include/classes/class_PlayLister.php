<?php
class PlayLister
{
    private $registry = null;
    private $fileMask = "icecast.playlist.%1s.txt";
    private $currList = null;
    private $currFile = null;

    public function __construct()
    {
        global $site;

        $this -> registry = $site;

        $this -> _getCurrentConfig();
    }

    public function __destruct()
    {
        unset($this -> registry);
    }

    public function getAllPlaylists()
    {
        $files = file($this -> registry -> config['all_playlists']);

        $output = array(
                      '<option value="0">' . output_string($this -> registry -> user_lang['global']['option_actions_select'], true) . '</option>'
                  );

        if ( count($files) ) {
            foreach( $files AS $file ) {
                $file = trim($file);
                if ( $this -> currList == $file ) {
                    $select = ' selected="select"';
                }
                else {
                    $select = '';
                }

                $output[] = '<option value="' . $file . '"' . $select . '>' . $file . '</option>';
            }
        }

        return implode("", $output);
    }

    public function getCurrentPlaylistContent($selectPlaylist = null)
    {
        if ( is_null($selectPlaylist) ) {
            $selectFileName = $this -> currFile;
        }
        else {
            $selectFileName = $this -> _makeSelectFilename($selectPlaylist);
        }

        $fullFilePath = $this -> registry -> config['config_home'] . '/' . $selectFileName;
        $renderer     = new Templater();

        if ( is_file($fullFilePath) ) {
            $listContent = file($fullFilePath);
            $output      = array();
            $lastLoad    = false;

            foreach( $listContent AS $key => $value ) {
                if ( $key == 0 ) {
                    $renderer -> loadTemplate('playlist-content-row-first.htm');
                    $lastLoad = true;
                }
                elseif ( $key == sizeof($listContent) - 1 AND $lastLoad ) {
                    $renderer -> loadTemplate('playlist-content-row-last.htm');
                    $lastLoad = false;
                }
                else {
                    $renderer -> loadTemplate('playlist-content-row.htm');
                }

                $renderer -> setVariable('current_key'     , $key);
                $renderer -> setVariable('current_position', $key + 1);
                $renderer -> setVariable('current_file'    , $this -> _fixedFilePath($value));
                $output[] = $renderer -> renderTemplate();
            }

            return implode("\n", $output);
        }
        else {
            // TODO :: ERROR-Message
            return 'ERROR-Message (' . $fullFilePath . ')';
        }
    }


    private function _getCurrentConfig()
    {
        $this -> currFile = file_get_contents($this -> registry -> config['current_filename']);
        $this -> currList = str_replace( array('icecast.playlist.', '.txt'), '', $this -> currFile);
    }

    private function _makeSelectFilename($filename = '')
    {
        return sprintf($this -> fileMask, $filename);
    }

    private function _fixedFilePath($path) {
        return str_replace(
                   array($this -> registry -> config['multimedia_root'], $this -> registry -> config['multimedia_link']),
                   '.',
                   $path
               );
    }
}
?>