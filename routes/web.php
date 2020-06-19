<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [\OnzaMe\JWT\Http\Middleware\JWTAuth::class]
], function () {
    Route::get('/test/jwt/authorization', fn () => 'Ok');
});
