<?php

class Bookability_Base
{

	public function __construct(Bookability $master)
	{
		$this->master = $master;
	}

	protected function transform($response, $request)
	{

		if ($request == 'find')
		{
			// For each data array within convert to object
		}
		else if ($request == 'get')
		{
			// If it is a get then change the data to an object
		}
		else
		{
			// Error
		}
	}
}