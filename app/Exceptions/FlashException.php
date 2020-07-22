<?php

namespace App\Exceptions;

use Exception;

abstract class FlashException extends Exception
{
    abstract public function flash();

    abstract public function getResponse();
}
