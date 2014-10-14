<?php 

error_reporting(E_ALL);
ini_set('display_errors', 'on');

class BookabilityTest extends PHPUnit_Framework_TestCase 
{
    public function testRunTest()
    {
		// Arrange
        $bookability = new Bookability();
		$bookability->dsn = 'http://username@project:your-key-goes-here@api.bookability.io:80/v1';
		
		// Test
		$this->assertTrue($bookability->ping());
    }
	
    public function testGetEvents()
    {
		// Arrange
        $bookability = new Bookability();
		$bookability->dsn = 'http://username@project:your-key-goes-here@api.bookability.io:80/v1';
		
		// Test
		$events = $bookability->events->find();
		
		// Test
		$this->assertTrue($events->count() > 0);
    }
}