<?php 

error_reporting(E_ALL);
ini_set('display_errors', 'on');

class CustomersTest extends PHPUnit_Framework_TestCase 
{	
    public function testListCustomers()
    {
		// Arrange
        $bookability = new Bookability();
		$bookability->dsn = 'http://username@project:your-key-goes-here@api.bookability.io:80/v1';
		
		// get customers
		$customers = $bookability->customers->find();
		
		// Test
		$this->assertTrue($customers->count() > 0);
    }
	
    public function testGetCustomer()
    {
		// Arrange
        $bookability = new Bookability();
		$bookability->dsn = 'http://username@project:your-key-goes-here@api.bookability.io:80/v1';
		
		// get customer
		$customer = $bookability->customers->get('fa6f1a3a8bcc4a6d1cc5100b8563b5fd');
		
		// Test
		$this->assertTrue((bool) $customer);
    }
}