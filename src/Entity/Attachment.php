<?php

declare(strict_types=1);

namespace Ntfy\Entity;

final class Attachment
{
    public function __construct(
        public string $name = '',
        public string $url = '',
        public string $type = '',
        public int $size = 0,
        public int $expires = 0,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'] ?? '',
            $data['url'] ?? '',
            $data['type'] ?? '',
            $data['size'] ?? 0,
            $data['expires'] ?? 0,
        );
    }
}
