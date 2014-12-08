<?php 

error_reporting(E_ALL);
ini_set('display_errors', 'on');

class BookingsTest extends PHPUnit_Framework_TestCase 
{	
    public function testListBookings()
    {
		// Arrange
        $bookability = new Bookability();
		$bookability->dsn = 'http://username@project:your-key-goes-here@api.bookability.io:80/v1';
		
		// get bookings
		$bookings = $bookability->bookings->find();
		
		// Test
		$this->assertTrue($bookings->count() > 0);
    }
	
    public function testGetBooking()
    {
		// Arrange
        $bookability = new Bookability();
		$bookability->dsn = 'http://username@project:your-key-goes-here@api.bookability.io:80/v1';
		
		// get booking
		$booking = $bookability->bookings->get('d1aa1cc22c5ac957a926ecd314d730be');
		
		// Test
		$this->assertTrue((bool) $booking);
    }
}