<?php

class Bookability_Base
{
	private $total = null;
	private $per_page = null;
	private $current_page = null;
	private $last_page = null;
	private $from = null;
	private $to = null;
	private $data = null;

	private function clear()
	{
		$total = null;
		$per_page = null;
		$current_page = null;
		$last_page = null;
		$from = null;
		$to = null;
		$data = null;
	}

	public function __construct(Bookability $master)
	{
		$this->master = $master;
	}

	protected function transform($response)
	{
		$this->clear();
		if (isset($response['total']))
		{
			$this->total = $response['total'];
		}
		if (isset($response['per_page']))
		{
			$this->per_page = $response['per_page'];
		}
		if (isset($response['current_page']))
		{
			$this->current_page = $response['current_page'];
		}
		if (isset($response['last_page']))
		{
			$this->last_page = $response['last_page'];
		}
		if (isset($response['from']))
		{
			$this->from = $response['from'];
		}
		if (isset($response['to']))
		{
			$this->to = $response['to'];
		}
		if (isset($response['data']))
		{
			$this->data = $response['data'];
			if (is_array($this->data))
			{
				$this->data = array_map(function ($item)
				{
					return (object)$item;
				}, $this->data);
			}
			return $this->data;
		}
		else
		{
			return $this->data = (object)$response;
		}
	}

	/**
	 * @return null
	 */
	public function getCurrentPage()
	{
		return $this->current_page;
	}

	/**
	 * @return null
	 */
	public function getFrom()
	{
		return $this->from;
	}

	/**
	 * @return null
	 */
	public function getLastPage()
	{
		return $this->last_page;
	}

	/**
	 * @return null
	 */
	public function getPerPage()
	{
		return $this->per_page;
	}

	/**
	 * @return null
	 */
	public function getTo()
	{
		return $this->to;
	}

	/**
	 * @return null
	 */
	public function getTotal()
	{
		return $this->total;
	}
}