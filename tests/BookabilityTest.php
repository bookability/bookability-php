<?php 

error_reporting(E_ALL);
ini_set('display_errors', 'on');

class BookabilityTest extends PHPUnit_Framework_TestCase 
{
    public function testRunTest()
    {
		// Arrange
        $bookability = new Bookability();
		$bookability->dsn = 'http://richard.davey@twosuperior:cf22642dab4e7942a9b9dd3f654042ad7ff9f7b8@api.bookability.test:80/v1';
		
		// Test
		$this->assertTrue($bookability->ping());
    }
	
    public function testGetEvents()
    {
		// Arrange
        $bookability = new Bookability();
		$bookability->dsn = 'http://richard.davey@twosuperior:cf22642dab4e7942a9b9dd3f654042ad7ff9f7b8@api.bookability.test:80/v1';
		
		// Test
		$events = $bookability->events->find();
		
		// Test
		$this->assertTrue(is_array($events));
    }
}