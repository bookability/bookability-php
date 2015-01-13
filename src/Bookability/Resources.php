<?php

class Bookability_Resources Extends Bookability_Base
{

    /**
     * Retrieve a list of resources
	 *
     * @return array
     */
    public function find($_params = array()) 
	{
        return $this->transform($this->master->get('resources', $_params));
    }
	
    /**
     * Retrieve a single resource
	 *
     * @return array
     */
    public function get($token) 
	{
		return $this->transform($this->master->get('resources/' . $token), true);
    }
	
    /**
     * Create a single resource
	 *
     * @return array
     */
    public function create($_params = array()) 
	{
        return $this->transform($this->master->post('resources', $_params), true);
    }
	
    /**
     * Update a single resource
	 *
     * @return array
     */
    public function update($token, $_params = array()) 
	{
        return $this->transform($this->master->put('resources/' . $token, $_params), true);
    }
	
    /**
     * Delete a single resource
	 *
     * @return array
     */
    public function delete($token) 
	{
        return $this->master->delete('resources/' . $token);
    }
}
