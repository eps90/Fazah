<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Utils;

class DateTimeFactory
{
    /**
     * @var \DateTimeImmutable|null
     */
    private static $frozenAt;

    public static function now(): \DateTimeImmutable
    {
        return self::$frozenAt ?? new \DateTimeImmutable('now');
    }

    public static function freezeDate(\DateTimeImmutable $date): void
    {
        self::$frozenAt = $date;
    }

    public static function unfreezeDate(): void
    {
        self::$frozenAt = null;
    }
}
