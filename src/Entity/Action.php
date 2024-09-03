<?php

declare(strict_types=1);

namespace Ntfy\Entity;

use Ntfy\Entity\Action\BroadcastAction;
use Ntfy\Entity\Action\HttpAction;
use Ntfy\Entity\Action\ViewAction;

abstract class Action
{
    public function __construct(
        public string $action = '',
        public string $label = '',
    ) {
    }

    public static function fromArray(array $data): self
    {
        return match ($data['action'] ?? null) {
            'broadcast' => BroadcastAction::fromArray($data),
            'http' => HttpAction::fromArray($data),
            'view' => ViewAction::fromArray($data),
            default => new ViewAction(),
        };
    }
}
