<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Message;

use Eps\Fazah\Core\Model\Identity\MessageId;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class EditMessage
{
    /**
     * @var MessageId
     */
    private $messageId;

    /**
     * @var array
     */
    private $messageData;

    public function __construct(MessageId $messageId, array $messageData)
    {
        $this->messageId = $messageId;
        $this->messageData = $this->resolveOptions($messageData);
    }

    /**
     * @return MessageId
     */
    public function getMessageId(): MessageId
    {
        return $this->messageId;
    }

    /**
     * @return array
     */
    public function getMessageData(): array
    {
        return $this->messageData;
    }

    private function resolveOptions(array $properties): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefined(['message_key', 'translated_message']);

        return $resolver->resolve($properties);
    }
}
