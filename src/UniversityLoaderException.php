<?php

/*
 * NOTICE OF LICENSE
 *
 * Part of the Rinvex University Package.
 *
 * This source file is subject to The MIT License (MIT)
 * that is bundled with this package in the LICENSE file.
 *
 * Package: Rinvex University Package
 * License: The MIT License (MIT)
 * Link:    https://rinvex.com
 */

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
