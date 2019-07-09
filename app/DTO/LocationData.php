<?php

namespace App\DTO;

class LocationData extends AbstractStructure
{
    public $formatted_address;
    public $geometry;
    public $place_id;
    public $address_components;

    public function getCountry()
    {
        $addressParts = explode(',', $this->formatted_address);
        return array_pop($addressParts);
    }
}

