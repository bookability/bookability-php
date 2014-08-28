<?php 

error_reporting(E_ALL);
ini_set('display_errors', 'on');

class ResourcesTest extends PHPUnit_Framework_TestCase 
{
    public function testListResources()
    {
		// Arrange
        $bookability = new Bookability();
		$bookability->root = 'http://www.bookability.test/api/v1';
		$bookability->username = 'richard.davey';
		$bookability->project = 'twosuperior';
		$bookability->apikey = 'cf22642dab4e7942a9b9dd3f654042ad7ff9f7b8';
		$bookability->debug = true;
		
		// get resources
		$resources = $bookability->resources->find();
		
		print_r($resources);
		// $this->assertTrue($bookability->test());
    }
}