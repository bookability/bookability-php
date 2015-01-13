<?php

class Bookability_Base
{
	public function __construct(Bookability $master)
	{
		$this->master = $master;
	}

	protected function transform($response, $single = false)
	{
		// create collection
		$collection = new Bookability_Collection();
			
		// has pagination or other data
		if (isset($response['meta']))
		{
			// get meta
			$meta = $response['meta'];
			
			// check for values
			if (isset($meta['total']))
			{
				$collection->total = $meta['total'];
			}
			if (isset($meta['per_page']))
			{
				$collection->perPage = $meta['per_page'];
			}
			if (isset($meta['current_page']))
			{
				$collection->currentPage = $meta['current_page'];
			}
			if (isset($meta['last_page']))
			{
				$collection->lastPage = $meta['last_page'];
			}
			if (isset($meta['from']))
			{
				$collection->from = $meta['from'];
			}
			if (isset($response['to']))
			{
				$collection->to = $meta['to'];
			}
		}
		
		// has data
		if (isset($response['data']))
		{
			$data = $response['data'];
			if (is_array($data))
			{
				if ($single) 
				{
					return $this->arrayToObject($data);
				}
				else
				{
					$collection->data = array_map(function ($item)
					{
						return $this->arrayToObject($item);
					}, $data);
				}
			}
		}
		
		// return collection
		return $collection;
	}
	
	protected function objectToArray($d) 
	{
	    if (is_object($d)) $d = get_object_vars($d);

	    return is_array($d) ? array_map([$this, __FUNCTION__], $d) : $d;
	}

	protected function arrayToObject($d) 
	{
	    return is_array($d) ? (object) array_map([$this, __FUNCTION__], $d) : $d;
	}
}