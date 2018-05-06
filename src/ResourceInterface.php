<?php

namespace MayMeow\API\Resource;

interface ResourceInterface
{
    /**
     * @return mixed
     */
    public function toArray();

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name);

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    public function __set($name, $value);

    /**
     * @param $entity
     * @return mixed
     */
    public static function collection($entity);
}