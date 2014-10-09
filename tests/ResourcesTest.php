<?php 

error_reporting(E_ALL);
ini_set('display_errors', 'on');

class ResourcesTest extends PHPUnit_Framework_TestCase 
{
    public function testListResources()
    {
		// Arrange
        $bookability = new Bookability();
		$bookability->dsn = 'http://richard.davey@twosuperior:cf22642dab4e7942a9b9dd3f654042ad7ff9f7b8@api.bookability.test:80/v1';
		
		// get resources
		$resources = $bookability->resources->find();
		
		// Test
		$this->assertTrue(is_array($resources));
    }
}