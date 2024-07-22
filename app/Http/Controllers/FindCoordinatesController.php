<?php

namespace App\Http\Controllers;

use App\Services\Maps\CoordinatesByAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class FindCoordinatesController extends Controller
{
    public function __construct(
        protected readonly CoordinatesByAddress $coordinatesByAddress
    )
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse($this->coordinatesByAddress->getCoordinates($request->get('address')));
    }
}
