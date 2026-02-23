<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use Neos\Flow\Annotations as Flow;

class AuthorizationServerFactory
{
    #[Flow\InjectConfiguration(path: 'privateKeyPath')]
    protected string $privateKeyPath;

    #[Flow\InjectConfiguration(path: 'encryptionKey')]
    protected string $encryptionKey;

    public function __construct(
        private readonly ClientRepositoryInterface $clientRepository,
        private readonly AccessTokenRepositoryInterface $accessTokenRepository,
        private readonly ScopeRepositoryInterface $scopeRepository,
    ) {
    }

    public function create(): AuthorizationServer
    {
        return new AuthorizationServer(
            clientRepository: $this->clientRepository,
            accessTokenRepository: $this->accessTokenRepository,
            scopeRepository: $this->scopeRepository,
            privateKey: $this->privateKeyPath,
            encryptionKey: $this->encryptionKey,
        );
    }
}
