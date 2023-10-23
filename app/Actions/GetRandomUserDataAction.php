<?php

namespace App\Actions;

;

use App\Models\User;
use App\Services\ThirdParty\RandomUserService;
use GuzzleHttp\Promise\Promise;
use Illuminate\Http\Client\Response;
use InvalidArgumentException;
use JsonException;

class GetRandomUserDataAction
{

    /**
     * Constructor.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(private readonly RandomUserService $api)
    {
    }

    public function execute(array $params = [])
    {
        $version = array_key_exists('version', $params) ? $params['version'] : null;
        if (array_key_exists('inc', $params) && count($params['inc']) >= 1) {
            if (!in_array('name', $params['inc'])) {
                $params['inc'][] = 'name';
            }

            if (!in_array('location', $params['inc'])) {
                $params['inc'][] = 'location';
            }
            $params['inc'] = implode(',', $params['inc']);
        }
        if (array_key_exists('exc', $params) && count($params['exc']) >= 1) {
            $params['exc'] = implode(',', $params['exc']);
        }

        $responseData = $this->api->call($version, $params);

        $sortedCollection = collect($responseData['results']);
        if (!$sortedCollection->isEmpty() && array_key_exists('name', $sortedCollection->first())) {
            $sortedCollection->sortBy(function ($item) {
                return $item['name']['last'];
            }, SORT_NATURAL, $params['order_by'] === 'DESC');
        }
        return $sortedCollection->map(function ($item) {
            return new User($item);
        });
    }
}
