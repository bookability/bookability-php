<?php

class Bookability_Events
{	
    public function __construct(Bookability $master) 
	{
        $this->master = $master;
    }

    /**
     * Retrieve the list of events
	 *
     * @return array of events
     */
    public function all() 
	{
        $_params = array();
        return $this->master->call('events', $_params);
    }
}