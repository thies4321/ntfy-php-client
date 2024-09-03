<?php

declare(strict_types=1);

namespace Ntfy\Entity;

use function is_array;
use function json_decode;

final class Message
{
    public const PRIORITY_MIN = 1;
    public const PRIORITY_LOW = 2;
    public const PRIORITY_DEFAULT = 3;
    public const PRIORITY_HIGH = 4;
    public const PRIORITY_MAX = 5;

    public const PRIORITIES = [
        self::PRIORITY_MIN,
        self::PRIORITY_LOW,
        self::PRIORITY_DEFAULT,
        self::PRIORITY_HIGH,
        self::PRIORITY_MAX,
    ];

    public function __construct(
        public string $id = '',
        public int $time = 0,
        public int $expires = 0,
        public string $event = '',
        public string $topic = 'test',
        public string $message = 'test',
        public ?string $template = null,
        public string $title = 'test',
        public array $tags = [],
        public int $priority = self::PRIORITY_DEFAULT,
        public string $click = '',
        public array $actions = [],
        public ?Attachment $attachment = null,
    ) {
    }

    public static function fromArray(array $message): self
    {
        $messageActions = json_decode($message['actions'] ?? '', true);
        $actions = [];

        if (is_array($messageActions)) {
            foreach ($messageActions as $messageAction) {
                $actions[] = Action::fromArray($messageAction);
            }
        }

        $messageAttachment = json_decode($message['attachment'] ?? '', true);
        $attachment = null;

        if (is_array($messageAttachment)) {
            $attachment = Attachment::fromArray($messageAttachment);
        }

        return new self(
            $message['id'] ?? '',
            $message['time'] ?? 0,
            $message['expires'] ?? 0,
            $message['event'] ?? '',
            $message['topic'] ?? 'test',
            $message['message'] ?? 'test',
            $message['title'] ?? 'test',
            $message['tags'] ?? [],
            $message['priority'] ?? self::PRIORITY_DEFAULT,
            $message['click'] ?? '',
            $actions,
            $attachment
        );
    }
}
