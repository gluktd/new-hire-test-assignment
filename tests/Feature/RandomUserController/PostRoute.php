<?php

it('returns redirect if validation error on version', function () {
    $response = $this->post('/api/random-user/data', [
        'version' => '1.0',
    ]);
    $response->assertStatus(302);
});

it('returns redirect if validation error on fields', function () {
    $response = $this->post('/api/random-user/data', [
        'inc' => ['full_name'],
    ]);
    $response->assertStatus(302);
});

it('returns redirect if validation error on custom fields', function () {
    $response = $this->post('/api/random-user/data', [
        'custom_fields' => ['name'],
    ]);
    $response->assertStatus(302);
});

it('returns redirect 200 on empty post data', function () {
    $response = $this->post('/api/random-user/data');
    $response->assertStatus(200);
});

it('returns xml response on outputFormat xml', function () {
    $response = $this->post('/api/random-user/data', [
        'output_format' => 'xml',
    ]);
    $response->assertHeader('Content-Type', 'application/xml');
    $response->assertStatus(200);
});

it('returns json response on outputFormat json', function () {
    $response = $this->post('/api/random-user/data', [
        'output_format' => 'json',
    ]);
    $response->assertHeader('Content-Type', 'application/json');
    $response->assertStatus(200);
});

it('has right stucture on response', function () {
    $response = $this->post('/api/random-user/data', [
        'output_format' => 'json',
    ]);
    $response->assertJsonStructure([
                                       '*' => [
                                           'full_name',
                                           'country',
                                           'phone',
                                           'email',
                                           'gender',
                                           'name' => ['title', 'first', 'last'],
                                           'location' => [
                                               'street' => ['number', 'name'],
                                               'city',
                                               'state',
                                               'country',
                                               'postcode',
                                               'coordinates' => ['latitude', 'longitude'],
                                               'timezone' => ['offset', 'description']
                                           ],
                                           'login' => [
                                               'uuid',
                                               'username',
                                               'password',
                                               'salt',
                                               'md5',
                                               'sha1',
                                               'sha256'
                                           ],
                                           'registered' => ['date', 'age'],
                                           'dob' => ['date', 'age'],
                                           'cell',
                                           'id',
                                           'picture' => ['large', 'medium', 'thumbnail'],
                                           'nat'
                                       ]
                                   ]);
    $response->assertStatus(200);
});
