<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server\Infrastructure;

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\ClientTrait;
use Neos\Flow\Security\Cryptography\HashService;
use Neos\Utility\Arrays;

/**
 * @Flow\Entity
 * @ORM\Table(
 *     name="sitegeist_flow_oauth2server_client",
 *     uniqueConstraints={
 *     },
 *     indexes={
 *     }
 * )
 */
class FlowClientEntity implements ClientEntityInterface
{
    use FlowIdentity, ClientTrait;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $secret;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $redirectUri;

    public function getSecret(): ?string
    {
        return $this->secret;
    }

    /**
     * Setting plain values won't work, use {@see HashService::hashPassword()} beforehand
     */
    public function setSecret(?string $secret): void
    {
        $this->secret = $secret;
        $this->isConfidential = $secret !== null;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function setRedirectUri($uri): void
    {
        $this->redirectUri = $uri;
    }

    /**
     * @return string|string[];
     */
    public function getRedirectUri(): mixed
    {
        if (\str_contains($this->redirectUri, PHP_EOL)) {
            return Arrays::trimExplode(PHP_EOL, $this->redirectUri);
        }

        return $this->redirectUri;
    }

    public function getRedirectUriAsString(): string
    {
        return $this->redirectUri;
    }
}
