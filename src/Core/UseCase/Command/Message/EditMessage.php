<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Message;

use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\UseCase\Command\SerializableCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class EditMessage implements SerializableCommand
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
        $this->messageData = self::resolveOptions($messageData);
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

    public static function fromArray(array $commandProps): self
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired(['message_id', 'message_data']);
        $props = $resolver->resolve($commandProps);

        $messageData = self::resolveOptions($props['message_data']);

        return new self(
            new MessageId((string)$props['message_id']),
            $messageData
        );
    }

    private static function resolveOptions(array $properties): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefined(['message_key', 'translated_message']);

        return $resolver->resolve($properties);
    }
}
