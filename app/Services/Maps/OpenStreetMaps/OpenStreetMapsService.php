<?php

namespace App\Services\Maps\OpenStreetMaps;

use App\Services\Maps\CoordinatesByAddress;
use App\Services\Maps\Directions;
use App\Services\Maps\NearbyPlaces;
use App\ValueObjects\Coordinates;
use Illuminate\Support\Facades\Http;

class OpenStreetMapsService implements CoordinatesByAddress, Directions, NearbyPlaces
{
    protected string $nominatimBaseUrl;
    protected string $openRouteServiceBaseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->nominatimBaseUrl = config('services.nominatim.base_url');
        $this->openRouteServiceBaseUrl = config('services.openrouteservice.base_url');
        $this->apiKey = config('services.openrouteservice.api_key');
    }

    public function getCoordinates(string $address): ?Coordinates
    {
        $response = Http::get("{$this->nominatimBaseUrl}/search", [
            'q' => $address,
            'format' => 'json',
            'addressdetails' => 1,
        ]);

        $data = $response->json();

        if (!empty($data)) {
            return new Coordinates(
                $data[0]['lat'],
                $data[0]['lon']
            );
        }

        return null;
    }

    public function getDirections(string $origin, string $destination): ?array
    {
        $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->openRouteServiceBaseUrl}/directions/driving-car", [
            'coordinates' => [
                [$origin['lon'], $origin['lat']],
                [$destination['lon'], $destination['lat']],
            ],
        ]);

        $data = $response->json();

        if (isset($data['routes'][0])) {
            return $data['routes'][0];
        }

        return null;
    }

    public function findNearbyPlaces(string $location, string $type, int $radius = 1000): ?array
    {
        $coordinates = $this->getCoordinates($location);

        $response = Http::get("https://nominatim.openstreetmap.org/search", [
            'q' => $type,
            'format' => 'json',
            'bounded' => 1,
            'viewbox' => implode(',', [
                $coordinates->getLongitude() - $radius / 111.32,
                $coordinates->getLatitude() - $radius / 111.32,
                $coordinates->getLongitude() + $radius / 111.32,
                $coordinates->getLatitude() + $radius / 111.32,
            ]),
        ]);

        $data = $response->json();

        if (!empty($data)) {
            return $data;
        }

        return null;
    }
}
