<?php

namespace App\Http\Controllers;

use App\Actions\GetRandomUserDataAction;
use App\Enums\ThirdParty\RandomUserCustomFieldsEnum;
use App\Enums\ThirdParty\RandomUserFieldsEnum;
use App\Enums\ThirdParty\RandomUserVersionEnum;
use App\Http\Requests\GetRandomUserDataRequest;
use App\Http\Resources\RandomUserResources;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Http\Response;
use Spatie\ArrayToXml\ArrayToXml;

class RandomUserController extends Controller
{
    public function getRandomUserData(
        GetRandomUserDataRequest $request,
        GetRandomUserDataAction $randomUserData
    ): \Illuminate\Foundation\Application|Response|JsonResponse|Application|ResponseFactory {
        $sortedCollection = $randomUserData->execute($request->validated());

        $collection = RandomUserResources::collection($sortedCollection)->map(function ($item) {
            return collect($item)->reject(function ($value) {
                return $value instanceof MissingValue;
            })->toArray();
        });
        if ($request->validated()['output_format'] === 'xml') {
            $xml = ArrayToXml::convert(['__numeric' => $collection->values()->all()]);
            return response($xml)
                ->header('Content-Type', 'application/xml');
        } else {
            return response()->json($collection);
        }
    }

    public function getAvailableVersions(): array
    {
        return RandomUserVersionEnum::cases();
    }

    public function getAvailableFields(): array
    {
        return RandomUserFieldsEnum::cases();
    }

    public function getAvailableCustomFields(): array
    {
        return RandomUserCustomFieldsEnum::cases();
    }
}
