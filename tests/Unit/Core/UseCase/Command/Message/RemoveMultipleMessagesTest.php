<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Message;

use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\UseCase\Command\Message\RemoveMultipleMessages;
use Eps\Fazah\Tests\Unit\Core\UseCase\Command\SerializableCommandTest;

class RemoveMultipleMessagesTest extends SerializableCommandTest
{
    public function validInputProperties(): array
    {
        return [
            [
                'input' => [
                    'message_ids' => [
                        '062e8492-286b-42a1-91ab-d5cfff5114dc',
                        'cc176d5b-574d-49e5-9d9b-2e86fe18b266',
                        '64b31b0f-68a9-420c-82d1-a0915475f137'
                    ]
                ],
                'expected' => new RemoveMultipleMessages([
                    new MessageId('062e8492-286b-42a1-91ab-d5cfff5114dc'),
                    new MessageId('cc176d5b-574d-49e5-9d9b-2e86fe18b266'),
                    new MessageId('64b31b0f-68a9-420c-82d1-a0915475f137')
                ])
            ]
        ];
    }

    public function invalidInputProperties(): array
    {
        return [
            [
                'input' => []
            ]
        ];
    }

    public function getCommandClass(): string
    {
        return RemoveMultipleMessages::class;
    }
}
