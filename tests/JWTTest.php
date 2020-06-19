<?php

namespace OnzaMe\JWT\Tests;

use Illuminate\Foundation\Auth\User;
use OnzaMe\JWT\Models\AccessToken;
use OnzaMe\JWT\Services\AccessTokenService;
use OnzaMe\JWT\Services\AuthorizationHeaderService;
use Orchestra\Testbench\TestCase;
use OnzaMe\JWT\JWTServiceProvider;

class JWTTest extends TestCase
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
        $service = app(AccessTokenService::class);
        $this->assertContains('super secret data', $service->decode($accessToken->token));
        $this->assertNotContains('test', $service->decode($accessToken->token));
        $this->assertContains('test', $service->decode($accessToken->refresh_token));
        $this->assertNotContains('super secret data', $service->decode($accessToken->refresh_token));
    }

    public function testFacadeOfAccessToken()
    {
        $accessTokenService = app(AccessTokenService::class);
        $this->assertTrue(is_a($accessTokenService, AccessTokenService::class));
    }

    public function testAuthorizationHeaderService()
    {
        $authHeaderService = app(AuthorizationHeaderService::class);
        $this->assertFalse($authHeaderService->isValid());
    }

    public function testValidatingMiddleware()
    {
        $payload = [
            'user' => [
                'id' => 'test',
                'role' => 'test'
            ]
        ];

        $token = new AccessToken($payload);

        $response = $this->get('/test/jwt/authorization', [
            'Authorization' => 'Bearer '.$token->token
        ]);
        $response->assertOk();
        $response->assertSeeText('Ok');
    }

    public function testValidatingMiddlewareWithError()
    {
        $response = $this->get('/test/jwt/authorization', [
            'Authorization' => 'Bearer test'
        ]);

        $response->assertUnauthorized();
    }
}
