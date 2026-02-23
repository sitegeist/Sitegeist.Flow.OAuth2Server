<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server\Infrastructure;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;
use Neos\Flow\Security\Cryptography\HashService;

/**
 * @method findOneByIdentifier(string $clientIdentifier): ?FlowClientEntity
 */
#[Flow\Scope('singleton')]
class FlowAccessTokenEntityRepository extends Repository implements AccessTokenRepositoryInterface
{

    /**
     * Create a new access token
     *
     * @param ScopeEntityInterface[] $scopes
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, int|string|null $userIdentifier = null): FlowAccessTokenEntity
    {
        $token = new FlowAccessTokenEntity();
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

    public function revokeAccessToken($tokenId)
    {
        // TODO: Implement revokeAccessToken() method.
    }

    public function isAccessTokenRevoked($tokenId)
    {
        // TODO: Implement isAccessTokenRevoked() method.
    }
}
