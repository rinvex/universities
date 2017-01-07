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

use ReflectionClass;
use Rinvex\University\University;
use PHPUnit_Framework_TestCase;
use Rinvex\University\UniversityLoader;
use Rinvex\University\UniversityLoaderException;

class UniversityLoaderTest extends PHPUnit_Framework_TestCase
{
    protected function reset_universities_property()
    {
        // Reset UniversityLoader::$universities property
        $reflectedLoader = new ReflectionClass(UniversityLoader::class);
        $reflectedProperty = $reflectedLoader->getProperty('universities');
        $reflectedProperty->setAccessible(true);
        $reflectedProperty->setValue(null, null);
    }

    /** @test */
    public function it_returns_university_data()
    {
        $universityArray = [
            'name' => 'Cairo University',
            'alt_name' => null,
            'country' => 'Egypt',
            'state' => null,
            'address' => [
                'street' => 'PO Box 12613, Nahdet Misr Street',
                'city' => 'Giza',
                'province' => 'Cairo',
                'postal_code' => null
            ],
            'contact' => [
                'telephone' => '+20(2) 572-9584',
                'website' => 'http://www.cu.edu.eg',
                'email' => 'scc@cu.edu.eg',
                'fax' => '+20(2) 568-8884'
            ],
            'funding' => 'Public',
            'languages' => null,
            'academic_year' => 'September to June (September-January; January-June)',
            'accrediting_agency' => null
        ];

        $this->assertEquals($universityArray, UniversityLoader::university('cairo-university', false));
        $this->assertEquals(new University($universityArray), UniversityLoader::university('cairo-university'));
    }

    /** @test */
    public function it_returns_universities_array()
    {
        $this->reset_universities_property();
        $this->assertEquals(181, count(UniversityLoader::universities()));
    }

    /** @test */
    public function it_returns_country_universities_array()
    {
        $this->reset_universities_property();
        $this->assertEquals(127, count(UniversityLoader::universities('egypt')));
        $this->assertInternalType('array', UniversityLoader::universities('egypt'));
        $this->assertContains('Cairo University', UniversityLoader::universities('egypt'));
    }

    /** @test */
    public function it_throws_an_exception_when_invalid_university()
    {
        $this->expectException(UniversityLoaderException::class);

        UniversityLoader::university('asd');
    }

    /** @test */
    public function it_gets_data()
    {
        $object = (object) ['users' => ['name' => ['Taylor', 'Otwell']]];
        $array = [(object) ['users' => [(object) ['name' => 'Taylor']]]];
        $dottedArray = ['users' => ['first.name' => 'Taylor', 'middle.name' => null]];
        $this->assertEquals('Taylor', UniversityLoader::get($object, 'users.name.0'));
        $this->assertEquals('Taylor', UniversityLoader::get($array, '0.users.0.name'));
        $this->assertNull(UniversityLoader::get($array, '0.users.3'));
        $this->assertEquals('Not found', UniversityLoader::get($array, '0.users.3', 'Not found'));
        $this->assertEquals('Not found', UniversityLoader::get($array, '0.users.3', function () {
            return 'Not found';
        }));
        $this->assertEquals('Taylor', UniversityLoader::get($dottedArray, ['users', 'first.name']));
        $this->assertNull(UniversityLoader::get($dottedArray, ['users', 'middle.name']));
        $this->assertEquals('Not found', UniversityLoader::get($dottedArray, ['users', 'last.name'], 'Not found'));
    }

    /** @test */
    public function it_returns_target_when_missing_key()
    {
        $this->assertEquals(['test'], UniversityLoader::get(['test'], null));
    }

    /** @test */
    public function it_gets_data_with_nested_arrays()
    {
        $array = [
            ['name' => 'taylor', 'email' => 'taylorotwell@gmail.com'],
            ['name' => 'abigail'],
            ['name' => 'dayle'],
        ];
        $this->assertEquals(['taylor', 'abigail', 'dayle'], UniversityLoader::get($array, '*.name'));
        $this->assertEquals(['taylorotwell@gmail.com', null, null], UniversityLoader::get($array, '*.email', 'irrelevant'));
        $array = [
            'users' => [
                ['first' => 'taylor', 'last' => 'otwell', 'email' => 'taylorotwell@gmail.com'],
                ['first' => 'abigail', 'last' => 'otwell'],
                ['first' => 'dayle', 'last' => 'rees'],
            ],
            'posts' => null,
        ];
        $this->assertEquals(['taylor', 'abigail', 'dayle'], UniversityLoader::get($array, 'users.*.first'));
        $this->assertEquals(['taylorotwell@gmail.com', null, null], UniversityLoader::get($array, 'users.*.email', 'irrelevant'));
        $this->assertEquals('not found', UniversityLoader::get($array, 'posts.*.date', 'not found'));
        $this->assertNull(UniversityLoader::get($array, 'posts.*.date'));
    }

    /** @test */
    public function it_gets_data_with_nested_double_nested_arrays_and_collapses_result()
    {
        $array = [
            'posts' => [
                [
                    'comments' => [
                        ['author' => 'taylor', 'likes' => 4],
                        ['author' => 'abigail', 'likes' => 3],
                    ],
                ],
                [
                    'comments' => [
                        ['author' => 'abigail', 'likes' => 2],
                        ['author' => 'dayle'],
                    ],
                ],
                [
                    'comments' => [
                        ['author' => 'dayle'],
                        ['author' => 'taylor', 'likes' => 1],
                    ],
                ],
            ],
        ];
        $this->assertEquals(['taylor', 'abigail', 'abigail', 'dayle', 'dayle', 'taylor'], UniversityLoader::get($array, 'posts.*.comments.*.author'));
        $this->assertEquals([4, 3, 2, null, null, 1], UniversityLoader::get($array, 'posts.*.comments.*.likes'));
        $this->assertEquals([], UniversityLoader::get($array, 'posts.*.users.*.name', 'irrelevant'));
        $this->assertEquals([], UniversityLoader::get($array, 'posts.*.users.*.name'));
    }

    /** @test */
    public function it_plucks_array()
    {
        $data = [
            'post-1' => [
                'comments' => [
                    'tags' => [
                        '#foo', '#bar',
                    ],
                ],
            ],
            'post-2' => [
                'comments' => [
                    'tags' => [
                        '#baz',
                    ],
                ],
            ],
        ];
        $this->assertEquals([
            0 => [
                'tags' => [
                    '#foo', '#bar',
                ],
            ],
            1 => [
                'tags' => [
                    '#baz',
                ],
            ],
        ], UniversityLoader::pluck($data, 'comments'));
        $this->assertEquals([['#foo', '#bar'], ['#baz']], UniversityLoader::pluck($data, 'comments.tags'));
        $this->assertEquals([null, null], UniversityLoader::pluck($data, 'foo'));
        $this->assertEquals([null, null], UniversityLoader::pluck($data, 'foo.bar'));
    }

    /** @test */
    public function it_plucks_array_with_array_and_object_values()
    {
        $array = [(object) ['name' => 'taylor', 'email' => 'foo'], ['name' => 'dayle', 'email' => 'bar']];
        $this->assertEquals(['taylor', 'dayle'], UniversityLoader::pluck($array, 'name'));
        $this->assertEquals(['taylor' => 'foo', 'dayle' => 'bar'], UniversityLoader::pluck($array, 'email', 'name'));
    }

    /** @test */
    public function it_plucks_array_with_nested_keys()
    {
        $array = [['user' => ['taylor', 'otwell']], ['user' => ['dayle', 'rees']]];
        $this->assertEquals(['taylor', 'dayle'], UniversityLoader::pluck($array, 'user.0'));
        $this->assertEquals(['taylor', 'dayle'], UniversityLoader::pluck($array, ['user', 0]));
        $this->assertEquals(['taylor' => 'otwell', 'dayle' => 'rees'], UniversityLoader::pluck($array, 'user.1', 'user.0'));
        $this->assertEquals(['taylor' => 'otwell', 'dayle' => 'rees'], UniversityLoader::pluck($array, ['user', 1], ['user', 0]));
    }

    /** @test */
    public function it_plucks_array_with_nested_arrays()
    {
        $array = [
            [
                'account' => 'a',
                'users'   => [
                    ['first' => 'taylor', 'last' => 'otwell', 'email' => 'foo'],
                ],
            ],
            [
                'account' => 'b',
                'users'   => [
                    ['first' => 'abigail', 'last' => 'otwell'],
                    ['first' => 'dayle', 'last' => 'rees'],
                ],
            ],
        ];
        $this->assertEquals([['taylor'], ['abigail', 'dayle']], UniversityLoader::pluck($array, 'users.*.first'));
        $this->assertEquals(['a' => ['taylor'], 'b' => ['abigail', 'dayle']], UniversityLoader::pluck($array, 'users.*.first', 'account'));
        $this->assertEquals([['foo'], [null, null]], UniversityLoader::pluck($array, 'users.*.email'));
    }

    /** @test */
    public function it_collapses_array()
    {
        $array = [[1], [2], [3], ['foo', 'bar'], ['baz', 'boom']];
        $this->assertEquals([1, 2, 3, 'foo', 'bar', 'baz', 'boom'], UniversityLoader::collapse($array));
    }

    /** @test */
    public function it_gets_file_content()
    {
        $this->assertStringEqualsFile(__DIR__.'/../resources/names.json', UniversityLoader::getFile(__DIR__.'/../resources/names.json'));
    }

    /** @test */
    public function it_throws_an_exception_when_invalid_file()
    {
        $this->expectException(UniversityLoaderException::class);

        UniversityLoader::getFile(__DIR__.'/../resources/invalid.json');
    }
}
