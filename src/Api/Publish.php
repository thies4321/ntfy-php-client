<?php

declare(strict_types=1);

namespace Ntfy\Api;

use Http\Client\Exception;
use Ntfy\Message;

use function is_array;
use function sprintf;

final class Publish extends AbstractApi
{
    /**
     * @throws Exception
     */
    public function send(Message $message): Message
    {
        $response = $this->post(sprintf('/%s', $message->topic), $message->message);

        if (is_array($response)) {
            return Message::fromArray($response);
        }

        return Message::fromArray(['message' => $response]);
    }
}
