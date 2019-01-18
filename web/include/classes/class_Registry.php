<?php
/**
* Class to store commonly-used variables
*/
class Registry
{
	// general objects
	/**
	* Input cleaner object.
	*
	* @var	Input_Cleaner
	*/
	var $input;

	/**
	* Database object.
	*
	* @var	Database
	*/
	var $db;

	// configuration
	/**
	* Array of data from config.php.
	*
	* @var	array
	*/
	var $config;

	// User-Configuration
	/**
	 * Array of data from custom_config.xml.
	 *
	 * @var	array
	 */
	var $user_config;

	// selected User-Language
	/**
	 * Array of data from lang.xml.
	 *
	 * @var	array
	 */
	var $user_lang;

	// GPC input
	/**
	* Array of data that has been cleaned by the input cleaner.
	*
	* @var	array
	*/
	var $GPC = array();

	/**
	* Array of booleans. When cleaning a variable, you often lose the ability
	* to determine if it was specified in the user's input. Entries in this
	* array are true if the variable existed before cleaning.
	*
	* @var	array
	*/
	var $GPC_exists = array();

	/**
	* The size of the super global arrays.
	*
	* @var	array
	*/
	var $superglobal_size = array();

	// single variables
	/**
	* IP Address of the current browsing user.
	*
	* @var	string
	*/
	var $ipaddress;

	/**
	* Alternate IP for the browsing user. This attempts to use various HTTP headers
	* to find the real IP of a user that may be behind a proxy.
	*
	* @var	string
	*/
	var $alt_ip;

	/**
	* The URL of the currently browsed page.
	*
	* @var	string
	*/
	var $scriptpath;

	/**
	* The URL of the current page, without anything after the '?'.
	*
	* @var	string
	*/
	var $script;

	/**
	* Generally the URL of the referring page if there is one, though it is often
	* set in various places of the code. Used to determine the page to redirect
	* to, if necessary.
	*
	* @var	string
	*/
	var $url;

	/**
	* Results for specific entries in the datastore.
	*
	* @var	mixed	Mixed, though mostly arrays.
	*/
	var $options       = null;
	var $templatecache = array();

	/**
	* Miscellaneous variables
	*
	* @var	mixed
	*/
	var $nozip;
	var $noheader;
	var $shutdown;


	/**
	* Constructor - initializes the nozip system,
	* and calls and instance of the Input_Cleaner class
	*/
    function __construct()
    {
		// variable to allow bypassing of gzip compression
		$this->nozip = defined('NOZIP') ? true : (@ ini_get('zlib.output_compression') ? true : false);
		// variable that controls HTTP header output
		$this->noheader = defined('NOHEADER') ? true : false;

		// initialize the input handler
		$this->input = new Input_Cleaner($this);

		// initialize the shutdown handler
		//$this->shutdown = Shutdown::init();
    }

	/**
	* Fetches database/system configuration
	*/
	function fetch_config()
	{
	    global $config;

		if (sizeof($config) == 0)
		{
			if (file_exists($path . '/include/configs/config_data.php'))
			{
				die('<br /><br /><strong>Konfigurationsfehler</strong>: Die Konfigurationsdatei /include/configs/config_data.php existiert nicht. Bitte konfigurieren Sie die Datei config_data.php.');
			}
			else
			{
				// config.php exists, but does not define $config
				die('<br /><br /><strong>Konfigurationsfehler</strong>: Die Konfigurationsdatei /include/configs/config_data.php existiert, ist aber nicht in einem gültigen Format.');
			}
		}

        // Protected-Config to Registry-Path
		$this -> config =& $config;
	}

	/**
	 * Fetches XML-Informations
	 */
	function fetch_xml()
	{
	    $this -> user_config = read_xml(CONF_PATH . '/custom_config.xml');
	    $this -> user_lang   = read_xml( $this -> config['base_path'] . '/language/' . $this -> user_config['language'] . '.xml' );
	}

	/**
	* store database configuration
	*/
	function fetch_database_config()
	{
	    $data = $this -> db -> queryObjectArray("SELECT * FROM config");

	    foreach($data AS $key => $val)
	    {
          $this -> site -> config[$val["name"]] = $val["wert"];
	    }
	}

	/**
	* Takes the contents of an array and recursively uses each title/data
	* pair to create a new defined constant.
	*/
	function array_define($array)
	{
		foreach ($array AS $title => $data)
		{
			if (is_array($data))
			{
				Registry::array_define($data);
			}
			else
			{
				define(strtoupper($title), $data);
			}
		}
	}
}
?>