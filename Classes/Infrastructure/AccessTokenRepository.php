<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server\Infrastructure;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;

/**
 * @method ?AccessToken findByIdentifier(string $clientIdentifier)
 */
#[Flow\Scope('singleton')]
class AccessTokenRepository extends Repository implements AccessTokenRepositoryInterface
{
    /**
     * Create a new access token
     *
     * @param ScopeEntityInterface[] $scopes
     * @param int|string|null $userIdentifier
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null): AccessToken
    {
        $token = new AccessToken();
        $token->setClient($clientEntity);
        $token->setUserIdentifier($userIdentifier);
        foreach ($scopes as $scope) {
            $token->addScope($scope);
        }
        return $token;
    }

    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity): void
    {
        $this->add($accessTokenEntity);
    }

    public function revokeAccessToken($tokenId): void
    {
        $token = $this->requireToken($tokenId);
        $token->setIsRevoked(true);
        $this->update($token);
    }

    public function isAccessTokenRevoked($tokenId): bool
    {
        return $this->requireToken($tokenId)->isRevoked();
    }

    private function requireToken(string $tokenId): AccessToken
    {
        $token = $this->findByIdentifier($tokenId);
        if ($token === null) {
            throw new \Exception('Unknown token ' . $tokenId);
        }

        return $token;
    }
}
