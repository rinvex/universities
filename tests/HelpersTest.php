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

namespace Rinvex\University\Test;

use Rinvex\University\University;
use PHPUnit_Framework_TestCase;

class HelpersTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_returns_university_data_through_helper()
    {
        $egypt = [
            'name' => 'Cairo University',
            'alt_name' => null,
            'country' => 'Egypt',
            'state' => null,
            'address' => [
                'street' => 'PO Box 12613, Nahdet Misr Street',
                'city' => 'Giza',
                'province' => 'Cairo',
                'postal_code' => null,
            ],
            'contact' => [
                'telephone' => '+20(2) 572-9584',
                'website' => 'http://www.cu.edu.eg',
                'email' => 'scc@cu.edu.eg',
                'fax' => '+20(2) 568-8884',
            ],
            'funding' => 'Public',
            'languages' => null,
            'academic_year' => 'September to June (September-January; January-June)',
            'accrediting_agency' => null,
        ];

        $this->assertEquals($egypt, university('cairo-university', false));
        $this->assertEquals(new University($egypt), university('cairo-university'));
    }

    /** @test */
    public function it_returns_universities_array_through_helper()
    {
        $this->assertEquals(181, count(universities()));
        $this->assertInternalType('array', universities('egypt'));
        $this->assertContains('Cairo University', universities('egypt'));
    }
}
