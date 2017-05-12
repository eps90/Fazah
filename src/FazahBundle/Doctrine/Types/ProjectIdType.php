<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Eps\Fazah\Core\Model\Identity\ProjectId;

final class ProjectIdType extends IdentityType
{
    const PROJECT_ID = 'project_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?ProjectId
    {
        $result = null;

        if ($value !== null) {
            $result = new ProjectId($value);
        }

        return $result;
    }

    protected function getIdentityType(): string
    {
        return ProjectId::class;
    }

    public function getName(): string
    {
        return self::PROJECT_ID;
    }
}
