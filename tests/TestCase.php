<?php

namespace MayMeow\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public static function dummyFunction($string)
    {
        return strtoupper($string);
    }
}