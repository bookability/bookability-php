<?php

class Bookability_Collection implements Iterator
{
	private $total = null;
	private $perPage = null;
	private $currentPage = null;
	private $lastPage = null;
	private $from = null;
	private $to = null;
	private $data = array();

	public function __construct($data = null)
    {
        if ($data)
			$this->setData($data);
    }
		
	public function __get($name) 
	{
		if (method_exists($this, $method = ('get' . ucfirst($name))))
		{
            return $this->$method();
        }
		else
        {
		    throw new Exception("Can't get property " . $name);
    	}
	}

    public function __set($name, $value ) 
	{
        if (method_exists($this, $method = ('set' . ucfirst($name))))
		{
            return $this->$method($value);
        }
		else
		{
			throw new Exception("Can't set property " . $name);
		}
    }

    public function __isset($name)
    {
        return method_exists($this, 'get' . ucfirst($name)) || method_exists($this, 'set' . ucfirst($name));
    }
	  
	/**
	 * Iterator method rewind
	 *
	 * @return void
	 */
    public function rewind()
    {
        reset($this->data);
    }

	/**
	 * Iterator method current
	 *
	 * @return mixed
	 */
    public function current()
    {
        return current($this->data);
    }

	/**
	 * Iterator method key
	 *
	 * @return mixed
	 */
    public function key() 
    {
        return key($this->data);
    }
	
	/**
	 * Iterator method next
	 *
	 * @return mixed
	 */
    public function next() 
    {
        return next($this->data);
    }

	/**
	 * Iterator method valid
	 *
	 * @return mixed
	 */
    public function valid()
    {
        $key = key($this->data);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }
		
	/**
	 * How many items
	 *
	 * @return mixed
	 */
    public function count() 
    {
        return count($this->data);
    }
	
	/**
	 * Get the current pagination page
	 *
	 * @return integer
	 */
	public function getCurrentPage()
	{
		return $this->currentPage;
	}

	/**
	 * Get the pagination from value
	 *
	 * @return integer
	 */
	public function getFrom()
	{
		return $this->from;
	}

	/**
	 * Get the last available page
	 *
	 * @return integer
	 */
	public function getLastPage()
	{
		return $this->lastPage;
	}

	/**
	 * Get the total number of items per pagination page
	 *
	 * @return integer
	 */
	public function getPerPage()
	{
		return $this->perPage;
	}

	/**
	 * Get the pagination to value
	 *
	 * @return integer
	 */
	public function getTo()
	{
		return $this->to;
	}

	/**
	 * Get the total number of items available
	 *
	 * @return integer
	 */
	public function getTotal()
	{
		return $this->total;
	}
	
	/**
	 * Set the current pagination page
	 *
	 * @return void
	 */
	public function setCurrentPage($value)
	{
		$this->currentPage = $value;
	}

	/**
	 * Set the pagination from value
	 *
	 * @return void
	 */
	public function setFrom($value)
	{
		$this->from = $value;
	}

	/**
	 * Set the last available page
	 *
	 * @return void
	 */
	public function setLastPage($value)
	{
		$this->lastPage = $value;
	}

	/**
	 * Set the total number of items per pagination page
	 *
	 * @return void
	 */
	public function setPerPage($value)
	{
		$this->perPage = $value;
	}

	/**
	 * Set the pagination to value
	 *
	 * @return void
	 */
	public function setTo($value)
	{
		$this->to = $value;
	}

	/**
	 * Set the total number of items available
	 *
	 * @return void
	 */
	public function setTotal($value)
	{
		$this->total = $value;
	}
	
	/**
	 * Set the data
	 *
	 * @return void
	 */
	public function setData($data)
	{
		if (is_array($data))
		{
			$this->data = $data;
		}
		else 
		{
			$this->data = [$data];
		}
	}
}