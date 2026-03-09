<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server\Infrastructure;

use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\ScopeTrait;
use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 * @ORM\Table(
 *     name="sitegeist_flow_oauth2server_scope",
 * )
 */
class Scope implements ScopeEntityInterface
{
    use FlowIdentity, ScopeTrait;

    /**
     * @phpstan-var ?string
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $description;

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
