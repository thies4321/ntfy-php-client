<?php

declare(strict_types=1);

namespace Ntfy;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Http\Client\Exception;
use Ntfy\Api\Publish;
use Ntfy\Enum\AuthenticationMethod;
use Ntfy\HttpClient\Builder;
use Ntfy\HttpClient\Plugin\Authentication;
use Ntfy\HttpClient\Plugin\ExceptionThrower;
use SensitiveParameter;

final class Client
{
    private const BASE_URL = 'https://ntfy.sh';
    private const USER_AGENT = 'ntfy-php-client/1.0';

    private Builder $httpClientBuilder;

    public function __construct(?Builder $httpClientBuilder = null)
    {
        $this->httpClientBuilder = $builder = $httpClientBuilder ?? new Builder();

        $builder->addPlugin(new ExceptionThrower());
        $builder->addPlugin(new HeaderDefaultsPlugin([
            'User-Agent' => self::USER_AGENT,
            'Content-Type' => 'text/plain',
        ]));
        $builder->addPlugin(new RedirectPlugin());

        $this->setUrl(self::BASE_URL);
    }

    public function getHttpClientBuilder(): Builder
    {
        return $this->httpClientBuilder;
    }

    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->getHttpClientBuilder()->getHttpClient();
    }

    public function setUrl(string $url): void
    {
        $uri = $this->getHttpClientBuilder()->getUriFactory()->createUri($url);

        $this->getHttpClientBuilder()->removePlugin(AddHostPlugin::class);
        $this->getHttpClientBuilder()->addPlugin(new AddHostPlugin($uri));
    }

    public function authenticate(
        #[SensitiveParameter] string $token,
        AuthenticationMethod $method = AuthenticationMethod::BearerToken
    ): void {
        $this->getHttpClientBuilder()->removePlugin(Authentication::class);
        $this->getHttpClientBuilder()->addPlugin(new Authentication($method, $token));
    }

    /**
     * @throws Exception
     */
    public function send(Message $message): Message
    {
        return (new Publish($this))->send($message);
    }
}
