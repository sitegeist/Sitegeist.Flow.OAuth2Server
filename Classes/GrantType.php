<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server;

enum GrantType
{
    case CLIENT_CREDENTIALS;
    case AUTHORIZATION_CODE;
}
