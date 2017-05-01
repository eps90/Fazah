<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model\Identity;

use Eps\Fazah\Core\Model\Identity\MessageId;

class MessageIdTest extends BaseIdentityTest
{
    protected function getIdentityClass(): string
    {
        return MessageId::class;
    }

    protected function getGenerateMethodName(): string
    {
        return 'generate';
    }
}
