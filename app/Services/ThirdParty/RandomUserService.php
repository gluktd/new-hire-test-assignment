<?php

namespace App\Services\ThirdParty;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

class RandomUserService
{
    private string $api_url;

    /**
     * Constructor.
     *
     *
     * @throws InvalidArgumentException
     */
    public function __construct()
    {
        if (empty(config('services.randomuser.url'))) {
            throw new InvalidArgumentException('Random User endpoint url is empty.');
        }
        $this->api_url = config('services.randomuser.url');
    }

    public function call(string $version = null, array $params = []): PromiseInterface|Response
    {
        $url = $this->api_url;
        if($version) {
            $url .= preg_replace('/^v/', '', $version) . '/';
        }
        if(!empty($params)){
            $queryString = Arr::query($params);
            $url .= '?' . $queryString;
        }
        return Http::acceptJson()->get($url);
    }


}
