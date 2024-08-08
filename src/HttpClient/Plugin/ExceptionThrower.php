<?php

declare(strict_types=1);

namespace Ntfy\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Ntfy\Exception\ApiLimitExceededException;
use Ntfy\Exception\ExceptionInterface;
use Ntfy\Exception\RuntimeException;
use Ntfy\Exception\ValidationFailedException;
use Ntfy\HttpClient\Message\ResponseMediator;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class ExceptionThrower implements Plugin
{

    /**
     * @throws ExceptionInterface
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        return $next($request)->then(function (ResponseInterface $response): ResponseInterface {
            $status = $response->getStatusCode();

            if ($status >= 400 && $status < 600) {
                throw self::createException($status, ResponseMediator::getErrorMessage($response) ?? $response->getReasonPhrase());
            }

            return $response;
        });
    }

    private static function createException(int $status, string $message): ExceptionInterface
    {
        if (400 === $status || 422 === $status) {
            return new ValidationFailedException($message, $status);
        }

        if (429 === $status) {
            return new ApiLimitExceededException($message, $status);
        }

        return new RuntimeException($message, $status);
    }
}
