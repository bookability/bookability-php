<?php 

error_reporting(E_ALL);
ini_set('display_errors', 'on');

class BundlesTest extends PHPUnit_Framework_TestCase 
{	
    public function testListBundles()
    {
		// Arrange
        $bookability = new Bookability();
		$bookability->dsn = 'http://username@project:your-key-goes-here@api.bookability.io:80/v1';
		
		// get bundles
		$bundles = $bookability->bundles->find();
		
		// Test
		$this->assertTrue($bundles->count() > 0);
    }
	
    public function testGetBundle()
    {
		// Arrange
        $bookability = new Bookability();
		$bookability->dsn = 'http://username@project:your-key-goes-here@api.bookability.io:80/v1';
		
		// get bundle
		$bundle = $bookability->bundles->get('11f84f081c9a0e40c9b71221c726bc88');
		
		// Test
		$this->assertTrue((bool) $bundle);
    }
}