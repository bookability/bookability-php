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
		$resource = $bookability->resources->get('d1d920d4532dadb0b2ff3bfa76022e97');
		
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
	
    public function testUpdateResourceg()
    {
		// Arrange
        $bookability = new Bookability();
		$bookability->dsn = 'http://username@project:your-key-goes-here@api.bookability.io:80/v1';
		
		// get booking
		$resource = $bookability->resources->update('d1d920d4532dadb0b2ff3bfa76022e97', ['name' => 'A Better Name']);
		
		// Test
		$this->assertTrue((bool) $resource);
    }
}