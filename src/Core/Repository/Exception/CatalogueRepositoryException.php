<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Exception;

use Eps\Fazah\Core\Model\Identity\CatalogueId;

class CatalogueRepositoryException extends RepositoryException
{
    public static function notFound(CatalogueId $catalogueId, \Throwable $previous = null): CatalogueRepositoryException
    {
        return self::generateNotFoundException($catalogueId, $previous);
    }

    protected static function getModelAlias(): string
    {
        return 'Catalogue';
    }

    protected static function getErrorCode(): int
    {
        return 2;
    }
}
