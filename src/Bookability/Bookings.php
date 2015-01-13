<?php

class Bookability_Bookings Extends Bookability_Base
{
    /**
     * Retrieve a list of bookings
	 *
     * @return array
     */
    public function find($_params = array()) 
	{
		return $this->transform($this->master->get('bookings', $_params));
    }
	
    /**
     * Retrieve a single booking
	 *
     * @return array
     */
    public function get($token) 
	{
		return $this->transform($this->master->get('bookings/' . $token), true);
    }
	
    /**
     * Create a single booking
	 *
     * @return array
     */
    public function create($_params = array()) 
	{
        return $this->transform($this->master->post('bookings', $_params), true);
    }
	
    /**
     * Update a single booking
	 *
     * @return array
     */
    public function update($token, $_params = array()) 
	{
        return $this->transform($this->master->put('bookings/' . $token, $_params), true);
    }
	
    /**
     * Delete a single booking
	 *
     * @return array
     */
    public function delete($token) 
	{
        return $this->master->delete('bookings/' . $token);
    }
}