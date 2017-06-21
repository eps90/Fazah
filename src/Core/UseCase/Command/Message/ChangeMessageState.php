<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Message;

use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Req2CmdBundle\Command\DeserializableCommandInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ChangeMessageState implements DeserializableCommandInterface
{
    /**
     * @var MessageId
     */
    private $messageId;

    /**
     * @var bool
     */
    private $shouldBeEnabled;

    public function __construct(MessageId $messageId, bool $shouldBeEnabled)
    {
        $this->messageId = $messageId;
        $this->shouldBeEnabled = $shouldBeEnabled;
    }

    /**
     * @return MessageId
     */
    public function getMessageId(): MessageId
    {
        return $this->messageId;
    }

    /**
     * @return bool
     */
    public function shouldBeEnabled(): bool
    {
        return $this->shouldBeEnabled;
    }

    public static function fromArray(array $commandProps): self
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired(['message_id', 'enabled']);
        $resolver->setAllowedTypes('enabled', 'bool');
        $props = $resolver->resolve($commandProps);

        return new self(
            new MessageId((string)$props['message_id']),
            (bool)$props['enabled']
        );
    }
}
