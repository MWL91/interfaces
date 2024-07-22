<?php

namespace App\Providers;

use App\Services\Maps\CoordinatesByAddress;
use App\Services\Maps\Directions;
use App\Services\Maps\DistanceMatrix;
use App\Services\Maps\GoogleMaps\GoogleMapsService;
use App\Services\Maps\NearbyPlaces;
use App\Services\Maps\OpenStreetMaps\OpenStreetMapsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CoordinatesByAddress::class,
            GoogleMapsService::class
        );

        $this->app->bind(
            Directions::class,
            OpenStreetMapsService::class
        );

        $this->app->bind(
            DistanceMatrix::class,
            GoogleMapsService::class
        );

        $this->app->bind(
            NearbyPlaces::class,
            GoogleMapsService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
