<?php

it('root route returns 200', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

