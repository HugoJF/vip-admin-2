<?php

namespace App\Traits;

use App\Filters\BaseFilter;
use Exception;

trait Filterable
{
	public function filtered()
	{
		foreach ($this->getFilters() as $class => $options) {
			if (!class_exists($class))
				throw new Exception("Filter $class is not a class");

			/** @var BaseFilter $filter */
			$filter = new $class;

			if (!$filter instanceof BaseFilter)
				throw new Exception("Invalid filter: $class");

			if ($filter->filtered($options))
				return true;
		}

		return false;
	}

	private function getFilters()
	{
		$split = preg_split('/:/', $this->filter);

		if (count($split) === 0)
			return [];

		if (empty($split[0]))
			return [];

		$key = $split[0];
		$class = $this->keyToClass($key);

		if (count($split) === 1)
			return [$class => null];

		$options = preg_split('/,/', $split[1]);

		$options = collect($options)->mapWithKeys(function ($opt) {
			$opt = preg_split('/=/', $opt);
			return [$opt[0] => $opt[1]];
		});

		return [$class => $options->toArray()];
	}

	protected function keyToClass($key)
	{
		if (array_key_exists($key, $this->filters)) {
			return $this->filters[ $key ];
		}

		throw new Exception("Could not find filter with key `$key`.");
	}
}