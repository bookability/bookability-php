<?php 

error_reporting(E_ALL);
ini_set('display_errors', 'on');

class BookabilityTest extends PHPUnit_Framework_TestCase 
{
    public function testRunTest()
    {
		// Arrange
        $bookability = new Bookability('api_key');

		// Test
		$this->assertTrue($bookability->test());
    }
	
    public function testGetEvents()
    {
		// Arrange
        $bookability = new Bookability('api_key');

		// Test
		$events = $bookability->events->find();
    }
}