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

use Exception;
use PHPUnit_Framework_TestCase;
use Rinvex\University\University;

class UniversityTest extends PHPUnit_Framework_TestCase
{
    /** @var array */
    protected $universityArray;

    /** @var \Rinvex\University\University */
    protected $universityObject;

    public function setUp()
    {
        parent::setUp();

        $this->universityArray = [
            'name' => 'Cairo University',
            'alt_name' => null,
            'country' => 'Egypt',
            'state' => null,
            'address' => [
                'street' => 'PO Box 12613, Nahdet Misr Street',
                'city' => 'Giza',
                'province' => 'Cairo',
                'postal_code' => '12613',
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

        $this->universityObject = new University($this->universityArray);
    }

    /** @test */
    public function it_throws_an_exception_when_missing_mandatory_attributes()
    {
        $this->expectException(Exception::class);

        new University([]);
    }

    /** @test */
    public function it_sets_attributes_once_instantiated()
    {
        $this->assertEquals($this->universityArray['name'], $this->universityObject->getName());
        $this->assertEquals($this->universityArray['alt_name'], $this->universityObject->getAltName());
        $this->assertEquals($this->universityArray['country'], $this->universityObject->getCountry());
    }

    /** @test */
    public function it_gets_attributes()
    {
        $this->assertEquals($this->universityArray, $this->universityObject->getAttributes());
    }

    /** @test */
    public function it_sets_attributes()
    {
        $this->universityObject->setAttributes(['state' => 'Giza']);

        $this->assertEquals('Giza', $this->universityObject->getState());
    }

    /** @test */
    public function it_gets_dotted_attribute()
    {
        $this->assertEquals($this->universityArray['address']['city'], $this->universityObject->get('address.city'));
    }

    /** @test */
    public function it_gets_default_when_missing_value()
    {
        $this->assertEquals('default', $this->universityObject->get('unknown', 'default'));
    }

    /** @test */
    public function it_gets_all_attributes_when_missing_key()
    {
        $this->assertEquals($this->universityArray, $this->universityObject->get(null));
    }

    /** @test */
    public function it_sets_attribute()
    {
        $this->universityObject->set('state', 'Giza');

        $this->assertEquals('Giza', $this->universityObject->getState());
    }

    /** @test */
    public function its_fluently_chainable_when_sets_attributes()
    {
        $this->assertEquals($this->universityObject, $this->universityObject->setAttributes([]));
    }

    /** @test */
    public function it_returns_name()
    {
        $this->assertEquals($this->universityArray['name'], $this->universityObject->getName());
    }

    /** @test */
    public function it_returns_null_when_missing_name()
    {
        $this->universityObject->setAttributes([]);

        $this->assertNull($this->universityObject->getName());
    }

    /** @test */
    public function it_returns_alternative_name()
    {
        $this->assertEquals($this->universityArray['alt_name'], $this->universityObject->getAltName());
    }

    /** @test */
    public function it_returns_null_when_missing_alternative_name()
    {
        $this->universityObject->setAttributes([]);

        $this->assertNull($this->universityObject->getAltName());
    }

    /** @test */
    public function it_returns_country()
    {
        $this->assertEquals($this->universityArray['country'], $this->universityObject->getCountry());
    }

    /** @test */
    public function it_returns_null_when_missing_country()
    {
        $this->universityObject->setAttributes([]);

        $this->assertNull($this->universityObject->getCountry());
    }

    /** @test */
    public function it_returns_state()
    {
        $this->assertEquals($this->universityArray['state'], $this->universityObject->getState());
    }

    /** @test */
    public function it_returns_null_when_missing_state()
    {
        $this->universityObject->setAttributes([]);

        $this->assertNull($this->universityObject->getState());
    }

    /** @test */
    public function it_returns_address()
    {
        $this->assertEquals($this->universityArray['address'], $this->universityObject->getAddress());
    }

    /** @test */
    public function it_returns_null_when_missing_address()
    {
        $this->universityObject->setAttributes([]);

        $this->assertNull($this->universityObject->getAddress());
    }

    /** @test */
    public function it_returns_street()
    {
        $this->assertEquals($this->universityArray['address']['street'], $this->universityObject->getStreet());
    }

    /** @test */
    public function it_returns_null_when_missing_street()
    {
        $this->universityObject->setAttributes([]);

        $this->assertNull($this->universityObject->getStreet());
    }

    /** @test */
    public function it_returns_city()
    {
        $this->assertEquals($this->universityArray['address']['city'], $this->universityObject->getCity());
    }

    /** @test */
    public function it_returns_null_when_missing_city()
    {
        $this->universityObject->setAttributes([]);

        $this->assertNull($this->universityObject->getCity());
    }

    /** @test */
    public function it_returns_province()
    {
        $this->assertEquals($this->universityArray['address']['province'], $this->universityObject->getProvince());
    }

    /** @test */
    public function it_returns_null_when_missing_province()
    {
        $this->universityObject->setAttributes([]);

        $this->assertNull($this->universityObject->getProvince());
    }

    /** @test */
    public function it_returns_postal_code()
    {
        $this->assertEquals($this->universityArray['address']['postal_code'], $this->universityObject->getPostalCode());
    }

    /** @test */
    public function it_returns_null_when_missing_postal_code()
    {
        $this->universityObject->setAttributes([]);

        $this->assertNull($this->universityObject->getPostalCode());
    }

    /** @test */
    public function it_returns_contact()
    {
        $this->assertEquals($this->universityArray['contact'], $this->universityObject->getContact());
    }

    /** @test */
    public function it_returns_null_when_missing_contact()
    {
        $this->universityObject->setAttributes([]);

        $this->assertNull($this->universityObject->getContact());
    }

    /** @test */
    public function it_returns_telephone()
    {
        $this->assertEquals($this->universityArray['contact']['telephone'], $this->universityObject->getTelephone());
    }

    /** @test */
    public function it_returns_null_when_missing_telephone()
    {
        $this->universityObject->setAttributes([]);

        $this->assertNull($this->universityObject->getTelephone());
    }

    /** @test */
    public function it_returns_website()
    {
        $this->assertEquals($this->universityArray['contact']['website'], $this->universityObject->getWebsite());
    }

    /** @test */
    public function it_returns_null_when_missing_website()
    {
        $this->universityObject->setAttributes([]);

        $this->assertNull($this->universityObject->getWebsite());
    }

    /** @test */
    public function it_returns_email()
    {
        $this->assertEquals($this->universityArray['contact']['email'], $this->universityObject->getEmail());
    }

    /** @test */
    public function it_returns_null_when_missing_email()
    {
        $this->universityObject->setAttributes([]);

        $this->assertNull($this->universityObject->getEmail());
    }

    /** @test */
    public function it_returns_fax()
    {
        $this->assertEquals($this->universityArray['contact']['fax'], $this->universityObject->getFax());
    }

    /** @test */
    public function it_returns_null_when_missing_fax()
    {
        $this->universityObject->setAttributes([]);

        $this->assertNull($this->universityObject->getFax());
    }

    /** @test */
    public function it_returns_funding()
    {
        $this->assertEquals($this->universityArray['funding'], $this->universityObject->getFunding());
    }

    /** @test */
    public function it_returns_null_when_missing_funding()
    {
        $this->universityObject->setAttributes([]);

        $this->assertNull($this->universityObject->getFunding());
    }

    /** @test */
    public function it_returns_languages()
    {
        $this->assertEquals($this->universityArray['languages'], $this->universityObject->getLanguages());
    }

    /** @test */
    public function it_returns_null_when_missing_languages()
    {
        $this->universityObject->setAttributes([]);

        $this->assertNull($this->universityObject->getLanguages());
    }

    /** @test */
    public function it_returns_academic_year()
    {
        $this->assertEquals($this->universityArray['academic_year'], $this->universityObject->getAcademicYear());
    }

    /** @test */
    public function it_returns_null_when_missing_academic_year()
    {
        $this->universityObject->setAttributes([]);

        $this->assertNull($this->universityObject->getAcademicYear());
    }

    /** @test */
    public function it_returns_accrediting_agency()
    {
        $this->assertEquals($this->universityArray['accrediting_agency'], $this->universityObject->getAccreditingAgency());
    }

    /** @test */
    public function it_returns_null_when_missing_accrediting_agency()
    {
        $this->universityObject->setAttributes([]);

        $this->assertNull($this->universityObject->getAccreditingAgency());
    }
}
