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

use Rinvex\University\UniversityLoader;

if (! function_exists('university')) {
    /**
     * Get the university by it's slug.
     *
     * @param string $code
     * @param bool   $hydrate
     *
     * @return \Rinvex\University\University|array
     */
    function university($code, $hydrate = true)
    {
        return UniversityLoader::university($code, $hydrate);
    }
}

if (! function_exists('universities')) {
    /**
     * Get universities for the given country.
     *
     * @param string|null $countryCode
     *
     * @return array
     */
    function universities($countryCode = null)
    {
        return UniversityLoader::universities($countryCode);
    }
}
