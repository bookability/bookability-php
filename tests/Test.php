<?php 

error_reporting(E_ALL);
ini_set('display_errors', 'on');

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

try 
{
	$bookability = new Bookability();
	$bookability->test();
} 
catch (Exception $e) 
{
	echo $e->getMessage();
}