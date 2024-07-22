<?php

namespace App\Services\Maps\GoogleMaps;

use App\Services\Maps\CoordinatesByAddress;
use App\Services\Maps\Directions;
use App\Services\Maps\DistanceMatrix;
use App\Services\Maps\NearbyPlaces;
use Illuminate\Support\Facades\Http;

class GoogleMapsService implements CoordinatesByAddress, Directions, NearbyPlaces, DistanceMatrix
{
    protected readonly string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.google_maps.api_key');
    }

    public function getCoordinates(string $address): ?array
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $address,
            'key' => $this->apiKey,
        ]);

        $data = $response->json();

        if ($data['status'] === 'OK') {
            return $data['results'][0]['geometry']['location'];
        }

        return null;
    }

    public function getDirections(string $origin, string $destination): ?array
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/directions/json', [
            'origin' => $origin,
            'destination' => $destination,
            'key' => $this->apiKey,
        ]);

        $data = $response->json();

        if ($data['status'] === 'OK') {
            return $data['routes'][0]['legs'][0];
        }

        return null;
    }

    public function findNearbyPlaces(string $location, string $type, int $radius = 1000): ?array
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/place/nearbysearch/json', [
            'location' => $location,
            'radius' => $radius,
            'type' => $type,
            'key' => $this->apiKey,
        ]);

        $data = $response->json();

        if ($data['status'] === 'OK') {
            return $data['results'];
        }

        return null;
    }

    public function getDistanceMatrix(string $origins, string $destinations): ?array
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json', [
            'origins' => $origins,
            'destinations' => $destinations,
            'key' => $this->apiKey,
        ]);

        $data = $response->json();

        if ($data['status'] === 'OK') {
            return $data['rows'][0]['elements'][0];
        }

        return null;
    }
}
