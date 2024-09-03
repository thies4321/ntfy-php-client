<?php

declare(strict_types=1);

namespace Ntfy\Api;

use Http\Client\Exception as HttpClientException;
use Ntfy\Entity\Message;

final class Messages extends AbstractApi
{
    /**
     * @throws HttpClientException
     */
    public function publish(Message $message): Message
    {
        $response = $this->post(sprintf('/%s', $message->topic), $message->message);

        if (is_array($response)) {
            return Message::fromArray($response);
        }

        return Message::fromArray(['message' => $response]);
    }
}
