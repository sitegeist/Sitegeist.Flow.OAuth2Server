<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use Neos\Flow\Annotations as Flow;

class AuthorizationServerFactory
{
    #[Flow\InjectConfiguration(path: 'privateKeyPath')]
    protected string $privateKeyPath;

    #[Flow\InjectConfiguration(path: 'encryptionKey')]
    protected string $encryptionKey;

    /**
     * @phpstan-var array{accessToken: string, authCode: string, refreshToken: string}
     */
    #[Flow\InjectConfiguration(path: 'ttls')]
    protected array $ttls;

    public function __construct(
        private readonly AccessTokenRepositoryInterface $accessTokenRepository,
        private readonly AuthCodeRepositoryInterface $authCodeRepository,
        private readonly ClientRepositoryInterface $clientRepository,
        private readonly RefreshTokenRepositoryInterface $refreshTokenRepository,
        private readonly ScopeRepositoryInterface $scopeRepository,
    ) {
    }

    public function create(GrantType $grantType): AuthorizationServer
    {
        $server = new AuthorizationServer(
            clientRepository: $this->clientRepository,
            accessTokenRepository: $this->accessTokenRepository,
            scopeRepository: $this->scopeRepository,
            privateKey: $this->privateKeyPath,
            encryptionKey: $this->encryptionKey,
        );

        $server->enableGrantType(
            grantType: match ($grantType) {
                GrantType::CLIENT_CREDENTIALS => new ClientCredentialsGrant(),
                GrantType::AUTHORIZATION_CODE => $this->createAuthCodeGrant(),
            },
            accessTokenTTL: new \DateInterval($this->ttls['accessToken']),
        );

        return $server;
    }

    private function createAuthCodeGrant(): AuthCodeGrant
    {
        $grant = new AuthCodeGrant(
            authCodeRepository: $this->authCodeRepository,
            refreshTokenRepository: $this->refreshTokenRepository,
            authCodeTTL: new \DateInterval($this->ttls['authCode']),
        );

        $grant->setRefreshTokenTTL(new \DateInterval($this->ttls['refreshToken']));

        return $grant;
    }
}
