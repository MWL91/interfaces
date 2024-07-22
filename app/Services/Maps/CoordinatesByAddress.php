<?php

namespace App\Services\Maps;

use App\ValueObjects\Coordinates;

interface CoordinatesByAddress
{
    public function getCoordinates(string $address): ?Coordinates;
}
