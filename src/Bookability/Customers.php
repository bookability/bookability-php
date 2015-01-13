<?php

class Bookability_Customers Extends Bookability_Base
{

    /**
     * Retrieve a list of customers
	 *
     * @return array
     */
    public function find($_params = array()) 
	{
		return $this->transform($this->master->get('customers', $_params));
    }
	
    /**
     * Retrieve a single customer
	 *
     * @return array
     */
    public function get($token) 
	{
		return $this->transform($this->master->get('customers/' . $token), true);
    }
	
    /**
     * Create a single customer
	 *
     * @return array
     */
    public function create($_params = array()) 
	{
        return $this->transform($this->master->post('customers', $_params), true);
    }
	
    /**
     * Update a single customer
	 *
     * @return array
     */
    public function update($token, $_params = array()) 
	{
        return $this->transform($this->master->put('customers/' . $token, $_params), true);
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