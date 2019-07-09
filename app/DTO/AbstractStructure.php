<?php

namespace App\DTO;

abstract class AbstractStructure
{
    public $rawData;

    /**
     * @param $data
     * @return static
     */
    public static function make($data)
    {
        return new static($data);
    }

    public function __construct($data = [])
    {
        $this->setProperties($data);
    }

    public function getProperties()
    {
        return get_object_vars($this);
    }

    /**
     * @param $data
     */
    public function setProperties($data)
    {
        if (!is_array($data)) {
            return;
        }

        $this->rawData = $data;
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function __toString()
    {
        $properties = $this->getProperties();
        if (count($properties) > 1) {
            // remove raw_data if we actually have some properties defined
            unset($properties['rawData']);
        }
        return json_encode($properties, JSON_PRETTY_PRINT);
    }

    public function toArray()
    {
        $properties = $this->getProperties();
        if (count($properties) > 1) {
            // remove raw_data if we actually have some properties defined
            unset($properties['rawData']);
        }
        return $properties;
    }
}
