<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Message;

use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\UseCase\Command\Message\EditMessage;
use Eps\Fazah\Tests\Unit\Core\UseCase\Command\SerializableCommandTest;

class EditMessageTest extends SerializableCommandTest
{
    /**
     * @test
     */
    public function itShouldSaveMessageProperties(): void
    {
        $messageProperties = [
            'message_key' => 'my.message',
            'translated_message' => 'Translated message'
        ];
        $command = new EditMessage(MessageId::generate(), $messageProperties);

        static::assertEquals($messageProperties, $command->getMessageData());
    }

    /**
     * @test
     */
    public function itShouldThrowWhenThereAreRedundantDataInProperties(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $messageProperties = [
            'message_key' => 'my_message',
            'redundant_value' => 'this should throw'
        ];
        new EditMessage(MessageId::generate(), $messageProperties);
    }

    public function validInputProperties(): array
    {
        return [
            [
                'props' => [
                    'message_id' => 'cf07637f-da5e-47af-9069-7793b4447206',
                    'message_data' => [
                        'message_key' => 'message_key',
                        'translated_message' => 'My translation'
                    ]
                ],
                'expected' => new EditMessage(
                    new MessageId('cf07637f-da5e-47af-9069-7793b4447206'),
                    [
                        'message_key' => 'message_key',
                        'translated_message' => 'My translation'
                    ]
                )
            ],
            [
                'props' => [
                    'message_id' => 'cf07637f-da5e-47af-9069-7793b4447206',
                    'message_data' => [
                        'translated_message' => 'My translation'
                    ]
                ],
                'expected' => new EditMessage(
                    new MessageId('cf07637f-da5e-47af-9069-7793b4447206'),
                    [
                        'translated_message' => 'My translation'
                    ]
                )
            ],
            [
                'props' => [
                    'message_id' => 'cf07637f-da5e-47af-9069-7793b4447206',
                    'message_data' => [
                        'message_key' => 'message_key'
                    ]
                ],
                'expected' => new EditMessage(
                    new MessageId('cf07637f-da5e-47af-9069-7793b4447206'),
                    [
                        'message_key' => 'message_key'
                    ]
                )
            ]
        ];
    }

    public function invalidInputProperties(): array
    {
        return [
            [
                'props' => [
                    'message_id' => 'cf07637f-da5e-47af-9069-7793b4447206',
                ]
            ],
            [
                'props' => [
                    'message_data' => [
                        'message_key' => 'message_key'
                    ]
                ]
            ],
            [
                'props' => []
            ]
        ];
    }

    public function getCommandClass(): string
    {
        return EditMessage::class;
    }
}
