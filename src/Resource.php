<?php

namespace MayMeow\API\Resource;

use Cake\ORM\Entity;

abstract class Resource implements ResourceInterface
{
    protected $entity;

    /**
     * Resource Constructor
     */
    public function __construct($entity)
    {   
        if ($entity instanceof Entity) $this->__set('entity', $entity);
    }

    /**
     * 
     */
    public function __get($name)
    {
        return $this->entity->$name;
    }

    /**
     * 
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * 
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
     * 
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