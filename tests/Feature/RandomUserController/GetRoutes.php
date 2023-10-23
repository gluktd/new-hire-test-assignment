<?php

use App\Enums\ThirdParty\RandomUserCustomFieldsEnum;
use App\Enums\ThirdParty\RandomUserVersionEnum;
use App\Enums\ThirdParty\RandomUserFieldsEnum;

it('returns a successful response random-user versions', function () {
    $response = $this->get('/api/random-user/versions');
    $expectedArray = RandomUserVersionEnum::values();
    $this->assertEquals($expectedArray, json_decode($response->content()));
});

it('returns a successful response random-user fields', function () {
    $response = $this->get('/api/random-user/fields');
    $expectedArray = RandomUserFieldsEnum::values();
    $this->assertEquals($expectedArray, json_decode($response->content()));
});

it('returns a successful response random-user custom-fields', function () {
    $response = $this->get('/api/random-user/custom-fields');
    $expectedArray = RandomUserCustomFieldsEnum::values();
    $this->assertEquals($expectedArray, json_decode($response->content()));
});
