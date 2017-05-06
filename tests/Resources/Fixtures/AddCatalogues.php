<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Resources\Fixtures;

use Carbon\Carbon;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Model\ValueObject\Metadata;

final class AddCatalogues extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $catalogueUuids = [
            'a853f467-403d-416b-8269-36369c34d723',
            '3df07fa8-80fa-4d5d-a0cb-9bcf3d830425',
            'b21deaae-8078-45e7-a83c-47a72e8d0458',
            '8094de70-b269-4ea3-a11c-4d43a5218b23',
            '5a53c071-f518-41af-9b94-71044b1d5a1f'
        ];
        $catalogueNames = [
            'first-catalogue',
            'second-catalogue',
            'third-catalogue',
            'forth-catalogue',
            'fifth-catalogue'
        ];
        /** @var Project[] $projects */
        $projects = [
            $this->getReference('first-project'),
            $this->getReference('first-project'),
            $this->getReference('first-project'),
            $this->getReference('second-project'),
            $this->getReference('second-project')
        ];
        $enabled = [
            true,
            true,
            true,
            true,
            false
        ];

        foreach ($catalogueNames as $idx => $catalogueName) {
            $metadata = Metadata::restoreFrom(
                Carbon::parse('2015-01-01 12:00:0' . $idx),
                Carbon::parse('2015-01-02 12:00:0' . $idx),
                $enabled[$idx]
            );
            $catalogue = Catalogue::restoreFrom(
                new CatalogueId($catalogueUuids[$idx]),
                $catalogueName,
                $projects[$idx]->getProjectId(),
                $metadata
            );
            $manager->persist($catalogue);
            $this->addReference("catalogue-$idx", $catalogue);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
