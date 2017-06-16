<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command;

interface SerializableCommand
{
    public static function fromArray(array $commandProps);
}
