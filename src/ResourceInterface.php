<?php

namespace MayMeow\API\Resource;

interface ResourceInterface
{
    public function toArray();

    public function __get($name);

    public function __set($name, $value);

    public static function collection($entity);
}