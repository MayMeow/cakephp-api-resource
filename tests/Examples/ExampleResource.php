<?php

namespace MayMeow\Tests\Examples;

use MayMeow\API\Resource\Resource;
use MayMeow\Tests\TestCase;

class ExampleResource extends Resource
{
    public function toArray()
    {
        return [
            'test' => $this->test,
            'upperText' => function ($q) {
                return TestCase::dummyFunction($q->test);
            }
        ];
    }
}