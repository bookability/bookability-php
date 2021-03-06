<?php

class Bookability_Availability Extends Bookability_Base
{	
    public function __construct(Bookability $master) 
	{
        $this->master = $master;
    }
	
    /**
     * Retrieve a list of availability for an event date range
	 *
     * @return array
     */
    public function find($token, $_params = array()) 
	{
        return $this->transform($this->master->get('availability/' . $token, $_params));
    }
	
    /**
     * Retrieve a list of availability for an event month
	 *
     * @return array
     */
    public function month($token, $_params = array()) 
	{
        return $this->transform($this->master->get('availability/' . $token . '/month', $_params), true);
    }
	
    /**
     * Retrieve a list of availability for a single event date
	 *
     * @return array
     */
    public function date($token, $_params = array()) 
	{
        return $this->transform($this->master->get('availability/' . $token . '/date', $_params), true);
    }
}