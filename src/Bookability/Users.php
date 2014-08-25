<?php

class Bookability_Users 
{	
    public function __construct(Bookability $master) 
	{
        $this->master = $master;
    }

    /**
     * Retrieve the list of users
	 *
     * @return array of users
     */
    public function all() 
	{
        $_params = array();
        return $this->master->call('users', $_params);
    }
}