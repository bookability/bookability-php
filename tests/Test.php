<?php 

class BookabilityTest extends PHPUnit_Framework_TestCase
{
    public function testCanTest()
    {
        // Arrange
        $bookability = new Bookability();

        // Act
      	$bookability->test();
    }
}