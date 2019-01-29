<?php
class PlayLister
{
    private $registry = null;
    private $fileMask = "icecast.playlist.%1s.txt";
    private $currList = null;
    private $currFile = null;

    private $currFilePath = null;
    private $protectFile  = 'On-The-Go';

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
        $listContent = $this -> _loadCurrentFile($selectPlaylist);

        if ( count($listContent) ) {
            $renderer = new Templater();
            $output   = array();
            $lastLoad = false;

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
            return 'ERROR-Message (' . $selectPlaylist . ')';
        }
    }

    public function switchFile($firstId = 0, $secoundId = 0, $selectList = null)
    {
        $result      = array('error' => false, 'message' => '');
        $listContent = $this -> _loadCurrentFile($selectList);

        if ( count($listContent) ) {
            if ( ($firstId >= 0) AND ($secoundId >= 0) AND ($firstId != $secoundId) ) {
                $countFiles = sizeof($listContent);
                if ( ($firstId < $countFiles) AND ($secoundId < $countFiles) ) {
                    $tmp                     = $listContent[$firstId];
                    $listContent[$firstId]   = $listContent[$secoundId];
                    $listContent[$secoundId] = $tmp;

                    if ( $this -> _saveCurrentFile($listContent) === false ) {
                        $result['error']   = true;
                        $result['message'] = output_string($this -> registry -> user_lang['global']['ajax_playlist_file_could_not_save'], false);
                    }
                    else {
                        $result['message'] = array(
                                                 'first'   => $firstId,
                                                 'secound' => $secoundId,
                                                 'file1'   => $this -> _fixedFilePath($listContent[$firstId]),
                                                 'file2'   => $this -> _fixedFilePath($listContent[$secoundId]),
                                             );
                    }
                }
                else {
                    $result['error']   = true;
                    $result['message'] = output_string($this -> registry -> user_lang['global']['ajax_playlist_fileid_out_of_range'], false);
                }
            }
            else {
                $result['error']   = true;
                $result['message'] = output_string($this -> registry -> user_lang['global']['ajax_playlist_fileid_error'], false);
            }
        }
        else {
            $result['error']   = true;
            $result['message'] = output_string($this -> registry -> user_lang['global']['ajax_playlist_file_load_error'], false);
        }

        return $result;
    }

    public function removeFile($fileId = 0, $selectList = null)
    {
        $result      = array('error' => false, 'message' => '');
        $listContent = $this -> _loadCurrentFile($selectList);

        if ( count($listContent) ) {
            if ( $fileId >= 0 ) {
                $countFiles = sizeof($listContent);
                if ( $fileId < $countFiles ) {
                    unset($listContent[$fileId]);

                    if ( $this -> _saveCurrentFile($listContent) === false ) {
                        $result['error']   = true;
                        $result['message'] = output_string($this -> registry -> user_lang['global']['ajax_playlist_file_could_not_save'], false);
                    }
                }
                else {
                    $result['error']   = true;
                    $result['message'] = output_string($this -> registry -> user_lang['global']['ajax_playlist_fileid_out_of_range'], false);
                }
            }
            else {
                $result['error']   = true;
                $result['message'] = output_string($this -> registry -> user_lang['global']['ajax_playlist_fileid_error'], false);
            }
        }
        else {
            $result['error']   = true;
            $result['message'] = output_string($this -> registry -> user_lang['global']['ajax_playlist_file_load_error'], false);
        }

        return $result;
    }

    public function clearCurrentPlaylist($selectList = null)
    {
        $result      = array('error' => false, 'message' => '');
        $listContent = $this -> _loadCurrentFile($selectList);

        if ( count($listContent) ) {
            if ( $this -> _saveCurrentFile('') === false ) {
                $result['error']   = true;
                $result['message'] = output_string($this -> registry -> user_lang['global']['ajax_playlist_file_could_not_save'], false);
            }
        }
        else {
            $result['error']   = true;
            $result['message'] = output_string($this -> registry -> user_lang['global']['ajax_playlist_file_load_error'], false);
        }

        return $result;
    }

    public function deleteCurrentPlaylist($selectList = null)
    {
        $result = array('error' => false, 'message' => '', 'reset' => false);

        $fullFilePath = $this -> registry -> config['config_home'] . '/' . $this -> _makeSelectFilename($selectList);

        if ( is_file($fullFilePath) ) {
            if ( $selectList != $this -> protectFile ) {
                if ( unlink( $fullFilePath) === false ) {
                     $result['error']   = true;
                     $result['message'] = output_string($this -> registry -> user_lang['global']['ajax_playlist_could_not_delete'], true);
                }

                $result['reset'] = true;
            }
            else {
                $result['error']   = true;
                $result['message'] = output_string($this -> registry -> user_lang['global']['ajax_playlist_protected_could_not_delete'], true);
            }
        }
        else {
            $result['error']   = true;
            $result['message'] = output_string($this -> registry -> user_lang['global']['ajax_playlist_file_load_error'], false);
        }

        return $result;
    }





    private function _saveCurrentFile($fileContent = null)
    {
        if ( !is_null($fileContent) ) {
            if ( is_array($fileContent) ) {
                $fileContent = implode("", $fileContent);
            }

            $bytesWrite = file_write($this -> currFilePath, $fileContent);

            return $bytesWrite;
        }
        else {
            // TODO :: ERROR-Message
            return 'Save-Data-Error';
        }
    }

    private function _loadCurrentFile($selectPlaylist = null)
    {
        if ( is_null($selectPlaylist) ) {
            $selectFileName = $this -> currFile;
        }
        else {
            $selectFileName = $this -> _makeSelectFilename($selectPlaylist);
        }

        $this -> currFilePath = $this -> registry -> config['config_home'] . '/' . $selectFileName;

        if ( is_file($this -> currFilePath) ) {
            return file($this -> currFilePath);
        }
        else {
            return false;
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