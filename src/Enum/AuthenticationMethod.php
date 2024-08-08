<?php

declare(strict_types=1);

namespace Ntfy\Enum;

enum AuthenticationMethod: string
{
    case BasicAuth = 'Basic';
    case BearerToken = 'Bearer';
    case QueryParam = 'Query';
}
