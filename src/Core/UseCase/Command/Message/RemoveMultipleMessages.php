<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Message;

use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Req2CmdBundle\Command\DeserializableCommandInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class RemoveMultipleMessages implements DeserializableCommandInterface
{
    /**
     * @var MessageId[]
     */
    private $messagesIds;

    public function __construct(array $messagesIds)
    {
        $this->messagesIds = (function (MessageId ...$messageIds) {
            return $messageIds;
        })(...$messagesIds);
    }

    public function getMessagesIds(): array
    {
        return $this->messagesIds;
    }

    public static function fromArray(array $commandProps): self
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('message_ids');
        $resolver->resolve($commandProps);

        $messageIds = array_map(function (string $messageId) {
            return new MessageId($messageId);
        }, $commandProps['message_ids']);

        return new self($messageIds);
    }
}
