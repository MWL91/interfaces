<?php

namespace App\Services\Maps;

interface NearbyPlaces
{
    public function findNearbyPlaces(string $location, string $type, int $radius = 1000): ?array;
}
