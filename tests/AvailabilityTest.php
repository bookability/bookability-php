<?php 

error_reporting(E_ALL);
ini_set('display_errors', 'on');

class AvailabilityTest extends PHPUnit_Framework_TestCase 
{
    public function testGetAvailability()
    {
		// Arrange
        $bookability = new Bookability();
		$bookability->dsn = 'http://username@project:your-key-goes-here@api.bookability.io:80/v1';
		
		// Test
		$availability = $bookability->availability->find('58831c907efbb9cc95a71586acf6ed91');
		
		// Test
		$this->assertTrue($availability->count() > 0);
    }
}