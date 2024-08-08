<?php

declare(strict_types=1);

namespace Ntfy;

final class Message
{
    public function __construct(
        public string $id = '',
        public int $time = 0,
        public int $expires = 0,
        public string $event = '',
        public string $topic = 'test',
        public string $message = 'test',
    ) {
    }

    public static function fromArray(array $message): self
    {
        return new self(
            $message['id'] ?? '',
            $message['time'] ?? 0,
            $message['expires'] ?? 0,
            $message['event'] ?? '',
            $message['topic'] ?? 'test',
            $message['message'] ?? 'test',
        );
    }
}
