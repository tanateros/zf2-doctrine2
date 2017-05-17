<?php
namespace Application\Entity;

/**
 * Class AbstractEntity
 * @package Application\Entity
 */
abstract class AbstractEntity
{
    /**
     * Exchange the object for another one.
     *
     * @param $data
     * @return $this
     */
    public function exchangeArray($data)
    {
        foreach ($data as $property=>$value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
        return $this;
    }

    /**
     *  Use properties of object as array
     *
     * @return mixed
     */
    public function toArray()
    {
        foreach ($this as $key => $property) {
            if (property_exists($this, $key)) {
                $vars[$key] = $property;
            }
        }

        return $vars;
    }
}