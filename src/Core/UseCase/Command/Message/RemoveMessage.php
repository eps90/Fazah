<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Message;

use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Req2CmdBundle\Command\DeserializableCommandInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class RemoveMessage implements DeserializableCommandInterface
{
    /**
     * @var MessageId
     */
    private $messageId;
    
    public function __construct(MessageId $messageId)
    {
        $this->messageId = $messageId;
    }
    
    public function getMessageId(): MessageId
    {
        return $this->messageId;
    }
    
    public static function fromArray(array $commandProps): self
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('message_id');
        $resolver->resolve($commandProps);
        
        return new self(new MessageId($commandProps['message_id']));
    }
}
