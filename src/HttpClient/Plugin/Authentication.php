<?php

declare(strict_types=1);

namespace Ntfy\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Ntfy\Enum\AuthenticationMethod;
use Psr\Http\Message\RequestInterface;
use SensitiveParameter;

use function sprintf;

final class Authentication implements Plugin
{
    public function __construct(
        private readonly AuthenticationMethod $method,
        #[SensitiveParameter] private readonly string $token
    ) {
    }

    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $request = match ($this->method) {
            AuthenticationMethod::BasicAuth, AuthenticationMethod::BearerToken => $this->withHeader($request, $this->method, $this->token),
            AuthenticationMethod::QueryParam => $this->withQueryParams($request, $this->token)
        };

        return $next($request);
    }

    private function withHeader(RequestInterface $request, AuthenticationMethod $method, string $token): RequestInterface
    {
        return $request->withHeader('Authentication', sprintf('%s %s', $method->value, $token));
    }

    private function withQueryParams(RequestInterface $request, string $token): RequestInterface
    {
        $uri = $request->getUri();
        $uri = $uri->withQuery(sprintf('auth=%s', $token));

        return $request->withUri($uri);
    }
}
