<?php

declare(strict_types=1);

namespace Ntfy\Api;

use Http\Client\Exception as HttpClientException;
use Ntfy\Client;
use Ntfy\HttpClient\Message\ResponseMediator;
use Ntfy\HttpClient\Util\QueryStringBuilder;

use function array_filter;
use function sprintf;

abstract class AbstractApi
{
    public function __construct(
        private readonly Client $client
    ) {
    }

    /**
     * @throws HttpClientException
     */
    protected function get(string $uri, array $params = [], array $headers = []): array|string
    {
        return ResponseMediator::getContent($this->client->getHttpClient()->get($this->prepareUri($uri, $params), $headers));
    }

    /**
     * @throws HttpClientException
     */
    protected function post(string $uri, string $content, array $params = [], array $headers = []): array|string
    {
        return ResponseMediator::getContent($this->client->getHttpClient()->post($this->prepareUri($uri, $params), $headers, $content));
    }

    private function prepareUri(string $uri, array $query = []): string
    {
        $query = array_filter($query, function ($value): bool {
            return null !== $value;
        });

        return sprintf('%s%s', $uri, QueryStringBuilder::build($query));
    }
}
