<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class AlreadyUsedTokenException extends Exception implements HttpExceptionInterface
{
    //
	/**
	 * Returns the status code.
	 *
	 * @return int An HTTP response status code
	 */
	public function getStatusCode()
	{
		return 400;
	}

	/**
	 * Returns response headers.
	 *
	 * @return array Response headers
	 */
	public function getHeaders()
	{
		return [];
	}
}
