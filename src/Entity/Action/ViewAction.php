<?php

declare(strict_types=1);

namespace Ntfy\Entity\Action;

use Ntfy\Entity\Action;

final class ViewAction extends Action
{
    public function __construct(
        public string $action = 'view',
        public string $label = '',
        public string $url = '',
        public bool $clear = false,
    ) {
        parent::__construct($this->action, $this->label);
    }

    public static function fromArray(array $data): Action
    {
        return new self(
            $data['action'] ?? 'view',
            $data['label'] ?? '',
            $data['url'] ?? '',
            $data['clear'] ?? false,
        );
    }
}
