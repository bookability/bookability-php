<?php

class Bookability_Events
{	
    public function __construct(Bookability $master) 
	{
        $this->master = $master;
    }

    /**
     * Retrieve a list of events
	 *
     * @return array
     */
    public function find($_params = array()) 
	{
        return $this->master->get('events', $_params);
    }
	
    /**
     * Retrieve a single event
	 *
     * @return array
     */
    public function get($token) 
	{
        return $this->master->get('events/' . $token);
    }
	
    /**
     * Create a single event
	 *
     * @return array
     */
    public function create($_params = array()) 
	{
        return $this->master->post('events', $_params);
    }
	
    /**
     * Update a single event
	 *
     * @return array
     */
    public function update($token, $_params = array()) 
	{
        return $this->master->put('events/' . $token, $_params);
    }
	
    /**
     * Delete a single event
	 *
     * @return array
     */
    public function delete($token) 
	{
        return $this->master->delete('events/' . $token);
    }
}