<?php

class Bookability_Customers 
{	
    public function __construct(Bookability $master) 
	{
        $this->master = $master;
    }

    /**
     * Retrieve the list of customers
	 *
     * @return array of customers
     */
    public function all() 
	{
        $_params = array();
        return $this->master->call('customers', $_params);
    }
}