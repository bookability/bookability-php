<?php

require_once 'Bookability/Bookings.php';
require_once 'Bookability/Customers.php';
require_once 'Bookability/Events.php';
require_once 'Bookability/Exceptions.php';
require_once 'Bookability/Resources.php';

/*
 * This file is part of the Bookability package.
 *
 * (c) Bookability
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Bookability
{
	/*
	 * Global curl object
	 *
	 */
    protected $ch;
	
	/*
	 * Declare API values
	 *
	 */
    public $dsn  	= 'https://www.bookability.io/api/v1';
    public $debug 	= false;

	/*
	 * Define error list
	 *
	 */
    public static $error_map = array(
        "ValidationError" => "Bookability_ValidationError"
    );

	// --------------------------------------------------------------------

	/*
	 * On creation of object, open cURL
	 *
	 */
    public function __construct($opts = array()) 
	{
		// load config file
		$config = $this->readConfigs();
		
		// merge config
		$config = array_merge($config, $opts);
			
		// init curl
        $this->ch = curl_init();
		
		// set default curl options
        curl_setopt($this->ch, CURLOPT_USERAGENT, 'Bookability-PHP/2.0.5');
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_HEADER, false);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 30);
		
		// initialize config
		$this->initialize($config);

		// load bookability modules
		$this->bookings = new Bookability_Bookings($this);
		$this->customers = new Bookability_Customers($this);
		$this->events = new Bookability_Events($this);
		$this->resources = new Bookability_Resources($this);
    }

	// --------------------------------------------------------------------

	/*
	 * On destruction of object, close cURL
	 *
	 */
    public function __destruct() 
	{
        curl_close($this->ch);
    }
	
	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
	private function initialize($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $value)
			{
				if (isset($this->{$key}))
				{
					$this->{$key} = $value;
				}
				else if (strpos($key, 'CURLOPT_') === 0) 
				{
					curl_setopt($this->ch, $key, $value);    
				}
			}
		}
	}
	
	// --------------------------------------------------------------------

	/*
	 * Make a call to the API
	 *
	 */
    public function call($path, $params, $verb = 'GET') 
	{		
		// check for dsn
        if (!$this->dsn) 
		{
            throw new Bookability_Error('You must provide a Bookability API DSN');
        }
		
		// parse dsn
		$url = parse_url($this->dsn);
		
		// check for host
        if (empty($url['host'])) 
		{
            throw new Bookability_Error('You must provide a Bookability API host');
        }
		
		// check for pass
        if (empty($url['pass'])) 
		{
            throw new Bookability_Error('You must provide a Bookability API key');
        }
		
		// check for user
        if (empty($url['user'])) 
		{
            throw new Bookability_Error('You must provide a Bookability API username');
        }
		else if (!strstr($url['user'], '@'))
		{
			throw new Bookability_Error('You must provide a Bookability API project alias');
		}
		
		// build url again
		$host = (!empty($url['scheme']) ? $url['scheme'] : 'http') . '://' . $url['host'] . (!empty($url['post']) ? (':' . $url['post']) : '') . (!empty($url['path']) ? $url['path'] : '');
		
		// clean host
		$host = rtrim($host, '/');
		
		// clean path
		$path = '/' . ltrim($path, '/');
		
		// encode parameters
        $params = json_encode($params);
        $ch     = $this->ch;
		
		// set up and override curl
        curl_setopt($ch, CURLOPT_URL, $host . $path);
		curl_setopt($ch, CURLOPT_USERPWD, $url['user'] . ':' . $url['pass']);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $verb);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_VERBOSE, $this->debug);

		// set blank object
		$response = new \stdClass();
	
		// start log
        $start = microtime(true);
        $this->log('Call to ' . $host . $path . $params);
        if ($this->debug) 
		{
            $curl_buffer = fopen('php://memory', 'w+');
            curl_setopt($ch, CURLOPT_STDERR, $curl_buffer);
        }

		// get response
		$response->content = curl_exec($ch);
		$response->header = curl_getinfo($ch);
		$response->error = null;
		
		// check for status code
		if (empty($response->header['http_code'])) 
		{
			$response->error = curl_errno($ch);
		}

		// end log
        $time = microtime(true) - $start;
        if($this->debug) 
		{
            rewind($curl_buffer);
            $this->log(stream_get_contents($curl_buffer));
            fclose($curl_buffer);
        }
        $this->log('Completed in ' . number_format($time * 1000, 2) . 'ms');
        $this->log('Got response: ' . $response->content);

		// error found
        if ($response->error) 
		{
            throw new Bookability_HttpError('API call to ' . $host . $path . ' failed: ' . $response->error);
        }
		
		// decode response
        $result = @json_decode($response->content, true);
        
        // check error code
		if (floor($response->header['http_code'] / 100) >= 4) 
		{
			// throw mapped error
            throw $this->castError($result);
        }

		// otherwise return data
        return $result;
    }

	// --------------------------------------------------------------------

	/*
	 * An alias for the GET call
	 *
	 */
    public function get($url, $params) 
	{
		return $this->call($url, $params, 'GET');
	}
	
	// --------------------------------------------------------------------

	/*
	 * An alias for the DELETE call
	 *
	 */
    public function delete($url, $params) 
	{
		return $this->call($url, $params, 'DELETE');
	}
	
	// --------------------------------------------------------------------

	/*
	 * An alias for the POST call
	 *
	 */
    public function post($url, $params) 
	{
		return $this->call($url, $params, 'POST');
	}
	
	// --------------------------------------------------------------------

	/*
	 * An alias for the PUT call
	 *
	 */
    public function put($url, $params) 
	{
		return $this->call($url, $params, 'PUT');
	}
	
	// --------------------------------------------------------------------

	/*
	 * Load additional config values
	 *
	 */
    public function readConfigs() 
	{
        $paths = array('~/bookability.ini', '/etc/bookability.ini');
        foreach($paths as $path) 
		{
            if (file_exists($path)) 
			{
                $config = parse_ini_file($path);
                if ($config) 
				{
                    return $config;
                }
            }
        }
        return array();
    }

	// --------------------------------------------------------------------

	/*
	 * Process errors
	 *
	 */
    public function castError($result) 
	{
		// look for error name
        if (empty($result['error']) || empty($result['name'])) 
		{
            throw new Bookability_Error('We received an unexpected error: ' . json_encode($result));
        }

		// map error
        $class = (isset(self::$error_map[$result['name']])) ? self::$error_map[$result['name']] : 'Bookability_Error';
        
		// return error
		return new $class($result['error'], $result['code']);
    }

	// --------------------------------------------------------------------

	/*
	 * Log for debug output
	 *
	 */
    public function log($msg) 
	{
        if ($this->debug) 
		{
            error_log($msg);
        }
    }
	
	// --------------------------------------------------------------------

	/*
	 * Simple class ping
	 *
	 */
    public function ping() 
	{
		return true;
	}
}