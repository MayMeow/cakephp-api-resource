<?php

namespace MayMeow\Tests\Features;

use MayMeow\Tests\TestCase;
use MayMeow\Tests\Examples\ExampleResource;
use Cake\ORM\Entity;

class ResourceTest extends TestCase
{
    /** @test */
    function test_single_resource()
    {
        $entity = new Entity(['test' => 'bar']);

        $resource = (new ExampleResource($entity))->get();

        $this->assertEquals(['test' => 'bar', 'upperText' => 'BAR'], $resource);
    }

    /** @test */
    function test_resource_collection()
    {
        $entities = [
            new Entity(['test' => 'a']),
            new Entity(['test' => 'b']),
        ];

        $resource = ExampleResource::collection($entities);

        $this->assertEquals([['test' => 'a', 'upperText' => 'A'],['test' => 'b', 'upperText' => 'B']], $resource);
    }
}