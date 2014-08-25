<?php

class Bookability_Resources
{	
    public function __construct(Bookability $master) 
	{
        $this->master = $master;
    }

    /**
     * Retrieve the list of resources
	 *
     * @return array of resources
     */
    public function all() 
	{
        $_params = array();
        return $this->master->call('resources', $_params);
    }
}