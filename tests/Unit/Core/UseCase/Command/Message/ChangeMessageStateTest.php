<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Message;

use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\UseCase\Command\Message\ChangeMessageState;
use Eps\Fazah\Tests\Unit\Core\UseCase\Command\SerializableCommandTest;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

class ChangeMessageStateTest extends SerializableCommandTest
{

    public function validInputProperties(): array
    {
        return [
            [
                'props' => [
                    'message_id' => '9748952d-3bd0-4618-912b-0b84257fd030',
                    'enabled' => true
                ],
                'expected' => new ChangeMessageState(
                    new MessageId('9748952d-3bd0-4618-912b-0b84257fd030'),
                    true
                )
            ]
        ];
    }

    public function invalidInputProperties(): array
    {
        return [
            [
                'props' => [
                    'message_id' => '9748952d-3bd0-4618-912b-0b84257fd030'
                ]
            ],
            [
                'props' => [
                    'enabled' => true
                ]
            ],
            [
                'props' => []
            ],
            [
                'props' => [
                    'message_id' => '9748952d-3bd0-4618-912b-0b84257fd030',
                    'enabled' => 'non-boolean-value'
                ],
                'exception' => InvalidOptionsException::class
            ]
        ];
    }

    public function getCommandClass(): string
    {
        return ChangeMessageState::class;
    }
}
