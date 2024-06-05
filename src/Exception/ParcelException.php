<?php

namespace App\Exception;

use Exception;
use Throwable;

class ParcelException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

// exemple: throw new ParcelException('Quantity max cannot be zero');

/* try {
    // Some code...
} catch (Exception $e) {
    throw new CustomException('Something went wrong', 0, $e);
} */
