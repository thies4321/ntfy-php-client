<?php

declare(strict_types=1);

namespace Ntfy\Entity\Action;

use Ntfy\Entity\Action;

final class HttpAction extends Action
{
    public function __construct(
        public string $action = 'http',
        public string $label = '',
        public string $url = '',
        public string $method = 'POST',
        public array $headers = [],
        public string $body = 'empty',
        public bool $clear = false,
    ) {
    }

    public static function fromArray(array $data): Action
    {
        return new self(
            $data['action'] ?? 'http',
            $data['label'] ?? '',
            $data['url'] ?? '',
            $data['method'] ?? 'POST',
            $data['headers'] ?? [],
            $data['body'] ?? '',
            $data['clear'] ?? false,
        );
    }
}
