<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Exception;

use Eps\Fazah\Core\Model\Identity\CatalogueId;

class CatalogueRepositoryException extends \LogicException
{
    public static function notFound(CatalogueId $catalogueId, \Throwable $previous = null): CatalogueRepositoryException
    {
        $message = sprintf('Catalogue with id %s does not exist', $catalogueId);
        $code = 2;
        return new self($message, $code, $previous);
    }

    public static function alreadyExists(CatalogueId $catalogueId, \Throwable $previous = null): CatalogueRepositoryException
    {
        $message = sprintf('Catalogue with id %s already exists', $catalogueId);
        $code = 2;
        return new self($message, $code, $previous);
    }
}
