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
		return $this->transform($this->master->get('customers', $_params), find);
    }
	
    /**
     * Retrieve a single customer
	 *
     * @return array
     */
    public function get($token) 
	{
		return $this->transform($this->master->get('customers/' . $token), get);
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