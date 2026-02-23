<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server\Infrastructure;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;

/**
 * @method findOneByIdentifier(string $identifier): ?FlowScopeEntity
 */
#[Flow\Scope('singleton')]
class FlowScopeEntityRepository extends Repository implements ScopeRepositoryInterface
{
    public function getScopeEntityByIdentifier($identifier): ?FlowScopeEntity
    {
        $scope = $this->findOneByIdentifier($identifier);

        return $scope instanceof FlowScopeEntity ? $scope : null;
    }

    /**
     * @param ScopeEntityInterface[] $scopes
     * @return ScopeEntityInterface[]
     */
    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ): array {
        return $scopes;
    }
}
