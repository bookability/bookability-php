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
	 * Declare API values
	 *
	 */
    public $ch;
    public $username;
    public $project;
    public $apikey;
    public $root  		= 'https://www.bookability.io/api/v1';
    public $debug 		= false;

	/*
	 * Define error list
	 *
	 */
    public static $error_map = array(
        "ValidationError" => "Bookability_ValidationError"
    );

	/*
	 * On creation of object, open cURL
	 *
	 */
    public function __construct($opts = array()) 
	{
        if (!isset($opts['timeout']) || !is_int($opts['timeout'])){
            $opts['timeout'] = 600;
        }
        if (isset($opts['debug'])){
            $this->debug = true;
        }

        $this->ch = curl_init();

        if (isset($opts['CURLOPT_FOLLOWLOCATION']) && $opts['CURLOPT_FOLLOWLOCATION'] === true) {
            curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);    
        }

        curl_setopt($this->ch, CURLOPT_USERAGENT, 'Bookability-PHP/2.0.5');
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_HEADER, false);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $opts['timeout']);

		$this->bookings = new Bookability_Bookings($this);
		$this->customers = new Bookability_Customers($this);
		$this->events = new Bookability_Events($this);
		$this->resources = new Bookability_Resources($this);
    }

	/*
	 * On destruction of object, close cURL
	 *
	 */
    public function __destruct() 
	{
        curl_close($this->ch);
    }
	
	/*
	 * Make a call to the API
	 *
	 */
    public function call($url, $params, $verb = 'GET') 
	{
        //if (!$this->apikey) {
           // $this->apikey = $this->readConfigs();
        //}
		
        if (!$this->apikey) {
            throw new Bookability_Error('You must provide a Bookability API key');
        }
		
        if (!$this->username) {
            throw new Bookability_Error('You must provide a Bookability API username');
        }
		
        if (!$this->project) {
            throw new Bookability_Error('You must provide a Bookability API project alias');
        }
        
        $params = json_encode($params);
        $ch     = $this->ch;
		
		$url = '/' . ltrim($url, '/');
		$this->root = rtrim($this->root, '/');
		
        curl_setopt($ch, CURLOPT_URL, $this->root . $url);
		curl_setopt($ch, CURLOPT_USERPWD, $this->username . '@' . $this->project . ':' . $this->apikey);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $verb);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_VERBOSE, $this->debug);

        $start = microtime(true);
        $this->log('Call to ' . $this->root . $url . $params);
        if ($this->debug) {
            $curl_buffer = fopen('php://memory', 'w+');
            curl_setopt($ch, CURLOPT_STDERR, $curl_buffer);
        }

        $response_body = curl_exec($ch);

        $info = curl_getinfo($ch);
        $time = microtime(true) - $start;
        if($this->debug) {
            rewind($curl_buffer);
            $this->log(stream_get_contents($curl_buffer));
            fclose($curl_buffer);
        }
        $this->log('Completed in ' . number_format($time * 1000, 2) . 'ms');
        $this->log('Got response: ' . $response_body);

        if(curl_error($ch)) {
            throw new Bookability_HttpError("API call to $url failed: " . curl_error($ch));
        }
		
        $result = json_decode($response_body, true);
        
        if (floor($info['http_code'] / 100) >= 4) {
            throw $this->castError($result . $info['http_code']);
        }

        return $result;
    }

	/*
	 * An alias for the GET call
	 *
	 */
    public function get($url, $params) 
	{
		return $this->call($url, $params, 'GET');
	}
	
	/*
	 * An alias for the DELETE call
	 *
	 */
    public function delete($url, $params) 
	{
		return $this->call($url, $params, 'DELETE');
	}
	
	/*
	 * An alias for the POST call
	 *
	 */
    public function post($url, $params) 
	{
		return $this->call($url, $params, 'POST');
	}
	
	/*
	 * An alias for the PUT call
	 *
	 */
    public function put($url, $params) 
	{
		return $this->call($url, $params, 'PUT');
	}
	
	/*
	 * Load additional config values
	 *
	 */
    public function readConfigs() 
	{
        $paths = array('~/.bookability.key', '/etc/bookability.key');
        foreach($paths as $path) {
            if(file_exists($path)) {
                $apikey = trim(file_get_contents($path));
                if ($apikey) {
                    return $apikey;
                }
            }
        }
        return false;
    }

	/*
	 * Process errors
	 *
	 */
    public function castError($result) 
	{
        if ($result['status'] !== 'error' || !$result['name']) {
            throw new Bookability_Error('We received an unexpected error: ' . json_encode($result));
        }

        $class = (isset(self::$error_map[$result['name']])) ? self::$error_map[$result['name']] : 'Bookability_Error';
        return new $class($result['error'], $result['code']);
    }

	/*
	 * Log for debug output
	 *
	 */
    public function log($msg) 
	{
        if ($this->debug) {
            error_log($msg);
        }
    }
	
	/*
	 * Simple class ping
	 *
	 */
    public function test() 
	{
		return true;
	}
}