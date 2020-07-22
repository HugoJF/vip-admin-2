<?php

namespace App\Filters;

use InvalidArgumentException;

abstract class BaseFilter
{
    protected $arguments = [];

    /**
     * @param array $options
     *
     * @return mixed
     */
    public function filtered(array $options)
    {
        if (!auth()->check()) {
            return false;
        }

        if ($this->checkArguments($options)) {
            return $this->isFiltered($options);
        }

        return false;
    }

    protected function checkArguments(array $options)
    {
        foreach ($this->arguments as $argument) {
            if (!array_key_exists($argument, $options)) {
                $c = get_class($this);

                throw new InvalidArgumentException("Missing argument $argument for filter {$c}");
            }
        }

        return true;
    }

    protected abstract function isFiltered(array $options);
}
