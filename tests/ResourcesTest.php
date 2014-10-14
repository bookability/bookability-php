<?php 

error_reporting(E_ALL);
ini_set('display_errors', 'on');

class ResourcesTest extends PHPUnit_Framework_TestCase 
{
    public function testListResources()
    {
		// Arrange
        $bookability = new Bookability();
		$bookability->dsn = 'http://username@project:your-key-goes-here@api.bookability.io:80/v1';
		
		// get resources
		$resources = $bookability->resources->find();

		// Test
		$this->assertTrue(is_array($resources));
    }
}