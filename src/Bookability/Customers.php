<?php

class Bookability_Customers
{	
    public function __construct(Bookability $master) 
	{
        $this->master = $master;
    }

    /**
     * Retrieve a list of customers
	 *
     * @return array
     */
    public function find($_params = array()) 
	{
        return $this->master->get('customers', $_params);
    }
	
    /**
     * Retrieve a single customer
	 *
     * @return array
     */
    public function get($token) 
	{
        return $this->master->get('customers/' . $token);
    }
	
    /**
     * Create a single customer
	 *
     * @return array
     */
    public function create($_params = array()) 
	{
        return $this->master->post('customers', $_params);
    }
	
    /**
     * Update a single customer
	 *
     * @return array
     */
    public function update($token, $_params = array()) 
	{
        return $this->master->put('customers/' . $token, $_params);
    }
	
    /**
     * Delete a single customer
	 *
     * @return array
     */
    public function delete($token) 
	{
        return $this->master->delete('customers/' . $token);
    }
}