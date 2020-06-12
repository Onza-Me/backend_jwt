<?php

namespace OnzaMe\JWT\Tests;

use OnzaMe\JWT\JWT;
use OnzaMe\JWT\Models\AccessToken;
use OnzaMe\JWT\RSAKeys;
use OnzaMe\JWT\Services\AccessTokenService;
use Orchestra\Testbench\TestCase;
use OnzaMe\JWT\JWTServiceProvider;

class JwtTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [JWTServiceProvider::class];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('jwt:rsa:generate');
    }

    /** @test */
    public function testAccessToken()
    {
        $accessToken = new AccessToken(['super secret data'], ['test']);
        $this->assertNotEmpty($accessToken->token);
        $this->assertNotEmpty($accessToken->refresh_token);

        return $accessToken;
    }

    /**
     * @param AccessToken $accessToken
     * @depends testAccessToken
     */
    public function testDecodingAccessToken(AccessToken $accessToken)
    {
        $service = new AccessTokenService(new JWT(), new RSAKeys());
        $this->assertContains('super secret data', $service->decode($accessToken->token));
        $this->assertNotContains('test', $service->decode($accessToken->token));
        $this->assertContains('test', $service->decode($accessToken->refresh_token));
        $this->assertNotContains('super secret data', $service->decode($accessToken->refresh_token));
    }
}
