<?php

namespace MayMeow\API\Resource;

use Cake\ORM\Entity;

/**
 * Class Resource
 * @package MayMeow\API\Resource
 */
abstract class Resource implements ResourceInterface
{
    /**
     * Cake\ORM\Entity $entity
     */
    protected $entity;

    /**
     * Resource constructor.
     * @param $entity
     */
    public function __construct($entity)
    {   
        if ($entity instanceof Entity) $this->__set('entity', $entity);
    }

    /**
     * Magic Getter
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->entity->$name;
    }

    /**
     * Magic Setter
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * Method get
     * returns resource properties array
     *
     * @return mixed
     */
    public function get()
    {
        $items = $this->toArray();

        // update variables when there is function
        foreach ($items as &$item)
        {
            // Run function
            if (is_callable($item)) {
                try {
                    $item = call_user_func($item, $this->entity);   // $item = function($q) {}
                } catch (\Exception $e) {
                    // Return nothing
                }
            }
        }

        return $items;
    }

    /**
     * Method collection
     * returns collection of resources properties arrays
     *
     * @property ResourceInterface $AnonymousResource
     *
     * @param $entity
     * @return array
     */
    public static function collection($entity)
    {
        $array = [];
        $AnonymousResource = get_called_class();

        foreach ($entity as $item)
        {
            $array[] = (new $AnonymousResource($item))->get();
        }
        
        return $array;
    }
}