<?php

namespace App\Services;

use App\DTO\LocationData;
use App\Http\Requests\CreatePackageRequest;
use App\Package;

class PackageService
{
    const DOMESTIC_RATE = 3;
    const INTERNATIONAL_RATE = 5;

    /**
     * @var GeolocationService
     */
    private $geolocationService;

    public function __construct(GeolocationService $geolocationService)
    {
        $this->geolocationService = $geolocationService;
    }

    public function make(CreatePackageRequest $request, $geolocation = null, $price = null)
    {
        $package = Package::create([
            'user_id' => $request->user()->id,
            'address' => $request->input('address'),
            'geolocation' => $geolocation,
            'price' => $price
        ]);
        return $package;
    }

    public function update(Package $package, $request, $geolocation = null, $price = null)
    {
        $package->address = $request->input('address');
        $package->geolocation = $geolocation;
        $package->price = $price;
        $package->saveOrFail();
        return $package;
    }

    public function calculate(LocationData $storeLocation, LocationData $location, $distance = null)
    {
        $distance = $distance ?? $this->geolocationService->getDistanceBetweenLocations($storeLocation, $location);
        if ($storeLocation->getCountry() === $location->getCountry()) {
            return static::DOMESTIC_RATE * $distance;
        } else {
            return static::INTERNATIONAL_RATE * $distance;
        }
    }
}
