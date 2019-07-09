<?php

namespace App\Services;

use App\DTO\LocationData;
use GuzzleHttp\Client;

class GeolocationService
{
    /**
     * @param $address
     * @return LocationData|bool
     */
    public function getLocation($address)
    {
        try {
            $client = new Client();
            $response = $client->get('https://maps.googleapis.com/maps/api/geocode/json', [
                'query' => [
                    'address' => $address,
                    'sensor' => false,
                    'key' => env('GOOGLE_MAPS_KEY')
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                $geodata = json_decode($response->getBody(), true, JSON_UNESCAPED_UNICODE);

                $status = $geodata['status'] ?? null;
                if ($status === 'OK') {
                    return LocationData::make($geodata['results'][0]);
                }
            }

            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * @param LocationData $from
     * @param LocationData $to
     * @return float
     */
    public function getDistanceBetweenLocations(LocationData $from, LocationData $to)
    {
        // Get latitude and longitude from the geodata
        $latitudeFrom  = $from->geometry['location']['lat'];
        $longitudeFrom = $from->geometry['location']['lng'];
        $latitudeTo    = $to->geometry['location']['lat'];
        $longitudeTo   = $to->geometry['location']['lng'];

        // Calculate distance between latitude and longitude
        $earthRadiusInKm = 6371;
        $dLat = deg2rad($latitudeFrom - $latitudeTo);
        $dLon = deg2rad($longitudeFrom - $longitudeTo);
        $a    = sin($dLat/2) * sin($dLat/2) + sin($dLon/2) * sin($dLon/2) * cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo));
        $c    = 2 * atan2(sqrt($a), sqrt(1-$a));
        return round($earthRadiusInKm * $c);
    }

    public function getStoreLocation()
    {
        $store = env('STORE_LOCATION', 'Novosibirsk');
        return $this->getLocation($store);
    }
}
