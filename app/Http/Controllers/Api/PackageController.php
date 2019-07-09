<?php

namespace App\Http\Controllers\Api;

use App\DTO\DeliveryData;
use App\Http\Requests\CreatePackageRequest;
use App\Package;
use App\Services\GeolocationService;
use App\Services\PackageService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Package as PackageResource;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class PackageController extends Controller
{
    /**
     * @var GeolocationService
     */
    private $geolocationService;

    /**
     * @var PackageService
     */
    private $packageService;

    public function __construct(GeolocationService $geolocationService, PackageService $packageService)
    {
        $this->geolocationService = $geolocationService;
        $this->packageService = $packageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Auth::user()->packages()->orderBy('id', 'desc')->get();
        return response(PackageResource::collection($packages));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePackageRequest $request)
    {
        if ($locationData = $this->geolocationService->getLocation($request->input('address'))) {
            $storeLocation = $this->geolocationService->getStoreLocation();
            $price = $this->packageService->calculate($storeLocation, $locationData);

            $package = $this->packageService->make($request, $locationData->rawData, $price);
            return response(PackageResource::make($package));
        }

        throw new BadRequestHttpException();
    }

    public function calculate(CreatePackageRequest $request)
    {
        if ($locationData = $this->geolocationService->getLocation($request->input('address'))) {
            $storeLocation = $this->geolocationService->getStoreLocation();

            $distance = $this->geolocationService->getDistanceBetweenLocations($storeLocation, $locationData);
            $price = $this->packageService->calculate($storeLocation, $locationData, $distance);

            $deliveryData = DeliveryData::make([
                'price' => $price,
                'distance' => $distance
            ]);
            return response()->json($deliveryData->toArray());
        }

        throw new BadRequestHttpException();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $package = $this->findModel($id);

        return new PackageResource($package);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreatePackageRequest $request, $id)
    {
        $package = $this->findModel($id);

        if ($locationData = $this->geolocationService->getLocation($request->input('address'))) {
            $storeLocation = $this->geolocationService->getStoreLocation();
            $price = $this->packageService->calculate($storeLocation, $locationData);

            $package = $this->packageService->update($package, $request, $locationData->rawData, $price);
            return response(PackageResource::make($package));
        }

        throw new BadRequestHttpException();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package = $this->findModel($id);

        if ($package->delete()) {
            return response(null, 204);
        }

        throw new BadRequestHttpException();
    }

    /**
     * @param $id
     * @return Package|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private function findModel($id)
    {
        return Package::query()->where('user_id', Auth::user()->getAuthIdentifier())->findOrFail($id);
    }
}
