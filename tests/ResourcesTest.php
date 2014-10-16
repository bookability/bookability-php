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
		$this->assertTrue($resources->count() > 0);
    }
	
    public function testGetResource()
    {
		// Arrange
        $bookability = new Bookability();
		$bookability->dsn = 'http://username@project:your-key-goes-here@api.bookability.io:80/v1';
		
		// get resources
		$resource = $bookability->resources->get('11f84f081c9a0e40c9b71221c726bc88');
		
		// Test
		$this->assertTrue((bool) $resource);
    }
	
    public function testCreateResource()
    {
		// Arrange
        $bookability = new Bookability();
		$bookability->dsn = 'http://username@project:your-key-goes-here@api.bookability.io:80/v1';
		
		// get resources
		$resource = $bookability->resources->create(['name' => 'Testing']);
		
		// Test
		$this->assertTrue((bool) $resource);
    }
}