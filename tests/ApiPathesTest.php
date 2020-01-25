<?php

namespace App\Tests;

use App\ApiPathes\EmptyAttribute;
use PHPUnit\Framework\TestCase;

use function App\ApiPathes\getApiPathes;

class ApiPathesTest extends TestCase
{
    public function testGetApiPathes()
    {
        $user = [
            'id' => 20,
            'name' => 'John Dow',
            'role' => 'QA',
            'salary' => 100
        ];
        
        $templates = [
            "/api/items/%id%/%name%",
            "/api/items/%id%/%role%",
            "/api/items/%id%/%salary%"
        ];

        $expected = [
            "/api/items/20/John%20Dow",
            "/api/items/20/QA",
            "/api/items/20/100"
        ];

        $this->assertEquals($expected, getApiPathes($user, $templates));
    }

    public function testExceptionApiPathes()
    {
        $user = [
            'asd' => 20,
            'name' => 'John Dow',
            'role' => 'QA',
            'salary' => 100
        ];

        $templates = [
            "/api/items/%id%/%name%",
            "/api/items/%id%/%role%",
            "/api/items/%id%/%salary%"
        ];

        $this->expectException(EmptyAttribute::class);
        getApiPathes($user, $templates);
    }
}
