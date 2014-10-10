<?php

class Bookability_Resources
{	
    public function __construct(Bookability $master) 
	{
        $this->master = $master;
    }

    /**
     * Retrieve a list of resources
	 *
     * @return array
     */
    public function find($_params = array()) 
	{
        return $this->master->get('resources', $_params);
    }
	
    /**
     * Retrieve a single resource
	 *
     * @return array
     */
    public function get($token) 
	{
        return $this->master->get('resources/' . $token);
    }
	
    /**
     * Create a single resource
	 *
     * @return array
     */
    public function create($_params = array()) 
	{
        return $this->master->post('resources', $_params);
    }
	
    /**
     * Update a single resource
	 *
     * @return array
     */
    public function update($token, $_params = array()) 
	{
        return $this->master->put('resources/' . $token, $_params);
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
