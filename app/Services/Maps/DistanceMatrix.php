<?php

namespace App\Services\Maps;

interface DistanceMatrix
{
    public function getDistanceMatrix(string $origins, string $destinations): ?array;
}
