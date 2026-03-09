<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server\Infrastructure;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;
use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 * @ORM\Table(
 *     name="sitegeist_flow_oauth2server_refreshtoken"
 * )
 */
class RefreshToken implements RefreshTokenEntityInterface
{
    use FlowToken, RefreshTokenTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Sitegeist\Flow\OAuth2Server\Infrastructure\AccessToken", cascade={"persist"})
     * @var AccessToken
     */
    protected $accessToken;
}
