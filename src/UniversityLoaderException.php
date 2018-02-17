<?php

declare(strict_types=1);

namespace Rinvex\University;

use Exception;

class UniversityLoaderException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @return static
     */
    public static function invalidUniversity()
    {
        return new static('University code may be misspelled, invalid, or data not found on server!');
    }
}
