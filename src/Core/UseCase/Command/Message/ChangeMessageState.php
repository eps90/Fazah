<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Message;

use Eps\Fazah\Core\Model\Identity\MessageId;

final class ChangeMessageState
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
}
