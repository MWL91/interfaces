<?php

namespace App\Services\Maps;

interface Directions
{
    public function getDirections(string $origin, string $destination): ?array;
}
