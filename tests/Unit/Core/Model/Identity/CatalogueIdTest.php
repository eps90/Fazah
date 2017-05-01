<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model\Identity;

use Eps\Fazah\Core\Model\Identity\CatalogueId;

class CatalogueIdTest extends BaseIdentityTest
{
    protected function getIdentityClass(): string
    {
        return CatalogueId::class;
    }

    protected function getGenerateMethodName(): string
    {
        return 'generate';
    }
}
