<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server\Infrastructure;

use Doctrine\Common\Collections\Collection;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Server\Entities\ClientEntityInterface;

/**
 * @Flow\Entity
 * @ORM\Table(
 *     name="sitegeist_flow_oauth2server_accesstoken"
 * )
 */
class FlowAccessTokenEntity implements AccessTokenEntityInterface
{
    use FlowIdentity, AccessTokenTrait;

    /**
     * @var \DateTimeImmutable
     */
    protected $expiryDateTime;

    /**
     * @var string
     */
    protected $userIdentifier;

    /**
     * @ORM\ManyToOne
     * @var FlowClientEntity
     */
    protected $client;

    /**
     * @var Collection<\Sitegeist\Flow\OAuth2Server\Infrastructure\FlowScopeEntity>
     * @ORM\ManyToOne
     * @ORM\ManyToMany(cascade={"persist"})
     * @Flow\Lazy
     */
    protected $scopes;

    public function getClient(): FlowClientEntity
    {
        return $this->client;
    }

    public function getExpiryDateTime(): \DateTimeImmutable
    {
        return $this->expiryDateTime;
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    /**
     * @return Collection<FlowScopeEntity>
     */
    public function getScopes(): Collection
    {
        return $this->scopes;
    }

    public function setExpiryDateTime(\DateTimeImmutable $dateTime): void
    {
        $this->expiryDateTime = $dateTime;
    }

    public function setUserIdentifier($identifier): void
    {
        $this->userIdentifier = $identifier;
    }

    public function setClient(ClientEntityInterface $client): void
    {
        $this->client = $client;
    }

    public function addScope(ScopeEntityInterface $scope): void
    {
        $this->scopes->add($scope);
    }

    public function getIdentifier(): string
    {
        return $this->getPersistenceObjectIdentifier();
    }
}
