<?php

class Bookability_Bookings 
{	
    public function __construct(Bookability $master) 
	{
        $this->master = $master;
    }

    /**
     * Retrieve the list of bookings
	 *
     * @return array of bookings
     */
    public function all() 
	{
        $_params = array();
        return $this->master->call('bookings', $_params);
    }
}