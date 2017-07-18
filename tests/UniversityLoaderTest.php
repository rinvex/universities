<?php

declare(strict_types=1);

namespace Rinvex\University\Test;

use ReflectionClass;
use PHPUnit\Framework\TestCase;
use Rinvex\University\University;
use Rinvex\University\UniversityLoader;
use Rinvex\University\UniversityLoaderException;

class UniversityLoaderTest extends TestCase
{
    /** @var array */
    protected static $methods;

    public static function setUpBeforeClass()
    {
        $reflectedLoader = new ReflectionClass(UniversityLoader::class);
        self::$methods['get'] = $reflectedLoader->getMethod('get');
        self::$methods['pluck'] = $reflectedLoader->getMethod('pluck');
        self::$methods['getFile'] = $reflectedLoader->getMethod('getFile');
        self::$methods['collapse'] = $reflectedLoader->getMethod('collapse');

        foreach (self::$methods as $method) {
            $method->setAccessible(true);
        }
    }

    public static function tearDownAfterClass()
    {
        self::$methods = null;
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

        $this->assertEquals($universityArray, UniversityLoader::university('cairo-university', false));
        $this->assertEquals(new University($universityArray), UniversityLoader::university('cairo-university'));
    }

    /** @test */
    public function it_returns_universities_array()
    {
        $this->assertEquals(181, count(UniversityLoader::universities()));
    }

    /** @test */
    public function it_returns_country_universities_array()
    {
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
        $this->assertEquals('Taylor', self::$methods['get']->invoke(null, $object, 'users.name.0'));
        $this->assertEquals('Taylor', self::$methods['get']->invoke(null, $array, '0.users.0.name'));
        $this->assertNull(self::$methods['get']->invoke(null, $array, '0.users.3'));
        $this->assertEquals('Not found', self::$methods['get']->invoke(null, $array, '0.users.3', 'Not found'));
        $this->assertEquals('Not found', self::$methods['get']->invoke(null, $array, '0.users.3', function () {
            return 'Not found';
        }));
        $this->assertEquals('Taylor', self::$methods['get']->invoke(null, $dottedArray, ['users', 'first.name']));
        $this->assertNull(self::$methods['get']->invoke(null, $dottedArray, ['users', 'middle.name']));
        $this->assertEquals('Not found', self::$methods['get']->invoke(null, $dottedArray, ['users', 'last.name'], 'Not found'));
    }

    /** @test */
    public function it_returns_target_when_missing_key()
    {
        $this->assertEquals(['test'], self::$methods['get']->invoke(null, ['test'], null));
    }

    /** @test */
    public function it_gets_data_with_nested_arrays()
    {
        $array = [
            ['name' => 'taylor', 'email' => 'taylorotwell@gmail.com'],
            ['name' => 'abigail'],
            ['name' => 'dayle'],
        ];
        $this->assertEquals(['taylor', 'abigail', 'dayle'], self::$methods['get']->invoke(null, $array, '*.name'));
        $this->assertEquals(['taylorotwell@gmail.com', null, null], self::$methods['get']->invoke(null, $array, '*.email', 'irrelevant'));
        $array = [
            'users' => [
                ['first' => 'taylor', 'last' => 'otwell', 'email' => 'taylorotwell@gmail.com'],
                ['first' => 'abigail', 'last' => 'otwell'],
                ['first' => 'dayle', 'last' => 'rees'],
            ],
            'posts' => null,
        ];
        $this->assertEquals(['taylor', 'abigail', 'dayle'], self::$methods['get']->invoke(null, $array, 'users.*.first'));
        $this->assertEquals(['taylorotwell@gmail.com', null, null], self::$methods['get']->invoke(null, $array, 'users.*.email', 'irrelevant'));
        $this->assertEquals('not found', self::$methods['get']->invoke(null, $array, 'posts.*.date', 'not found'));
        $this->assertNull(self::$methods['get']->invoke(null, $array, 'posts.*.date'));
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
        $this->assertEquals(['taylor', 'abigail', 'abigail', 'dayle', 'dayle', 'taylor'], self::$methods['get']->invoke(null, $array, 'posts.*.comments.*.author'));
        $this->assertEquals([4, 3, 2, null, null, 1], self::$methods['get']->invoke(null, $array, 'posts.*.comments.*.likes'));
        $this->assertEquals([], self::$methods['get']->invoke(null, $array, 'posts.*.users.*.name', 'irrelevant'));
        $this->assertEquals([], self::$methods['get']->invoke(null, $array, 'posts.*.users.*.name'));
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
        ], self::$methods['pluck']->invoke(null, $data, 'comments'));
        $this->assertEquals([['#foo', '#bar'], ['#baz']], self::$methods['pluck']->invoke(null, $data, 'comments.tags'));
        $this->assertEquals([null, null], self::$methods['pluck']->invoke(null, $data, 'foo'));
        $this->assertEquals([null, null], self::$methods['pluck']->invoke(null, $data, 'foo.bar'));
    }

    /** @test */
    public function it_plucks_array_with_array_and_object_values()
    {
        $array = [(object) ['name' => 'taylor', 'email' => 'foo'], ['name' => 'dayle', 'email' => 'bar']];
        $this->assertEquals(['taylor', 'dayle'], self::$methods['pluck']->invoke(null, $array, 'name'));
        $this->assertEquals(['taylor' => 'foo', 'dayle' => 'bar'], self::$methods['pluck']->invoke(null, $array, 'email', 'name'));
    }

    /** @test */
    public function it_plucks_array_with_nested_keys()
    {
        $array = [['user' => ['taylor', 'otwell']], ['user' => ['dayle', 'rees']]];
        $this->assertEquals(['taylor', 'dayle'], self::$methods['pluck']->invoke(null, $array, 'user.0'));
        $this->assertEquals(['taylor', 'dayle'], self::$methods['pluck']->invoke(null, $array, ['user', 0]));
        $this->assertEquals(['taylor' => 'otwell', 'dayle' => 'rees'], self::$methods['pluck']->invoke(null, $array, 'user.1', 'user.0'));
        $this->assertEquals(['taylor' => 'otwell', 'dayle' => 'rees'], self::$methods['pluck']->invoke(null, $array, ['user', 1], ['user', 0]));
    }

    /** @test */
    public function it_plucks_array_with_nested_arrays()
    {
        $array = [
            [
                'account' => 'a',
                'users' => [
                    ['first' => 'taylor', 'last' => 'otwell', 'email' => 'foo'],
                ],
            ],
            [
                'account' => 'b',
                'users' => [
                    ['first' => 'abigail', 'last' => 'otwell'],
                    ['first' => 'dayle', 'last' => 'rees'],
                ],
            ],
        ];
        $this->assertEquals([['taylor'], ['abigail', 'dayle']], self::$methods['pluck']->invoke(null, $array, 'users.*.first'));
        $this->assertEquals(['a' => ['taylor'], 'b' => ['abigail', 'dayle']], self::$methods['pluck']->invoke(null, $array, 'users.*.first', 'account'));
        $this->assertEquals([['foo'], [null, null]], self::$methods['pluck']->invoke(null, $array, 'users.*.email'));
    }

    /** @test */
    public function it_collapses_array()
    {
        $array = [[1], [2], [3], ['foo', 'bar'], ['baz', 'boom']];
        $this->assertEquals([1, 2, 3, 'foo', 'bar', 'baz', 'boom'], self::$methods['collapse']->invoke(null, $array));
    }

    /** @test */
    public function it_gets_file_content()
    {
        $this->assertStringEqualsFile(__DIR__.'/../resources/names.json', self::$methods['getFile']->invoke(null, __DIR__.'/../resources/names.json'));
    }

    /** @test */
    public function it_throws_an_exception_when_invalid_file()
    {
        $this->expectException(UniversityLoaderException::class);

        self::$methods['getFile']->invoke(null, __DIR__.'/../resources/invalid.json');
    }
}
