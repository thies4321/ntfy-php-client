<?php

declare(strict_types=1);

namespace Ntfy\Entity\Action;

use Ntfy\Entity\Action;

final class BroadcastAction extends Action
{
    public function __construct(
        public string $action = 'broadcast',
        public string $label = '',
        public string $intent = 'io.heckel.ntfy.USER_ACTION',
        public array $extras = [],
        public bool $clear = false,
    ) {
        parent::__construct($this->action, $this->label);
    }

    public static function fromArray(array $data): Action
    {
        return new self(
            $data['action'] ?? 'broadcast',
            $data['label'] ?? '',
            $data['intent'] ?? 'io.heckel.ntfy.USER_ACTION',
            $data['extras'] ?? [],
            $data['clear'] ?? false,
        );
    }
}
