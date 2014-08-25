<?php

require_once 'Bookability/Bookings.php';
require_once 'Bookability/Customers.php';
require_once 'Bookability/Events.php';
require_once 'Bookability/Exceptions.php';
require_once 'Bookability/Resources.php';
require_once 'Bookability/Users.php';

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
    public $apikey;
    public $ch;
    public $root  = 'https://www.bookability.io/api';
    public $debug = false;

    public static $error_map = array(
        "ValidationError" => "Bookability_ValidationError"
    );

    public function __construct($apikey = null, $opts = array()) 
	{
        if (!$apikey) {
            $apikey = getenv('BOOKABILITY_APIKEY');
        }

        if (!$apikey) {
            $apikey = $this->readConfigs();
        }

        if (!$apikey) {
            throw new Bookability_Error('You must provide a Bookability API key');
        }

        $this->apikey = $apikey;
        $dc           = "us1";

        if (strstr($this->apikey, "-")){
            list($key, $dc) = explode("-", $this->apikey, 2);
            if (!$dc) {
                $dc = "us1";
            }
        }

        $this->root = str_replace('https://api', 'https://' . $dc . '.api', $this->root);
        $this->root = rtrim($this->root, '/') . '/';

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


		$this->users = new Bookability_Bookings($this);
		$this->users = new Bookability_Customers($this);
		$this->users = new Bookability_Events($this);
		$this->users = new Bookability_Resources($this);
		$this->users = new Bookability_Users($this);
    }

    public function __destruct() 
	{
        curl_close($this->ch);
    }

    public function call($url, $params) 
	{
        $params['apikey'] = $this->apikey;
        
        $params = json_encode($params);
        $ch     = $this->ch;

        curl_setopt($ch, CURLOPT_URL, $this->root . $url . '.json');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_VERBOSE, $this->debug);

        $start = microtime(true);
        $this->log('Call to ' . $this->root . $url . '.json: ' . $params);
        if($this->debug) {
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
        
        if(floor($info['http_code'] / 100) >= 4) {
            throw $this->castError($result);
        }

        return $result;
    }

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

    public function castError($result) 
	{
        if ($result['status'] !== 'error' || !$result['name']) {
            throw new Bookability_Error('We received an unexpected error: ' . json_encode($result));
        }

        $class = (isset(self::$error_map[$result['name']])) ? self::$error_map[$result['name']] : 'Bookability_Error';
        return new $class($result['error'], $result['code']);
    }

    public function log($msg) 
	{
        if ($this->debug) {
            error_log($msg);
        }
    }
	
    public function test() 
	{
		echo 'Hello';
	}
}