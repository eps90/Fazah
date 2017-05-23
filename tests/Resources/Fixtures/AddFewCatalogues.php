<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Resources\Fixtures;

use Carbon\Carbon;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Model\ValueObject\ProjectConfiguration;

final class AddFewCatalogues implements FixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $firstProject = Project::restoreFrom(
            new ProjectId('584d8b6a-7eb0-4ef4-a54e-0eb16bb86138'),
            'first_project',
            Metadata::restoreFrom(
                Carbon::parse('2015-01-01 12:00:00'),
                Carbon::parse('2015-01-01 13:00:00'),
                true
            ),
            ProjectConfiguration::restoreFrom(
                ['en', 'fr']
            )
        );
        $secondProject = Project::restoreFrom(
            new ProjectId('0bacbf16-dfc8-4e39-9ca1-581d9158c3d5'),
            'second_project',
            Metadata::restoreFrom(
                Carbon::parse('2016-01-01 12:00:00'),
                Carbon::parse('2016-01-01 13:00:00'),
                true
            ),
            ProjectConfiguration::restoreFrom(
                ['fr']
            )
        );

        $firstCatalogue = Catalogue::restoreFrom(
            new CatalogueId('12853ef6-43a5-4e7f-8ff5-3fb47ef10a07'),
            'first_catalogue',
            $firstProject->getId(),
            null,
            Metadata::restoreFrom(
                Carbon::parse('2015-01-01 12:00:00'),
                Carbon::parse('2015-01-02 13:00:00'),
                true
            ),
            'first_catalogue'
        );
        $secondCatalogue = Catalogue::restoreFrom(
            new CatalogueId('aba1afb9-8513-4657-844c-8df297e335b4'),
            'second_catalogue',
            $firstProject->getId(),
            null,
            Metadata::restoreFrom(
                Carbon::parse('2015-01-01 12:00:00'),
                Carbon::parse('2015-01-02 13:00:00'),
                false
            ),
            'second_catalogue'
        );
        $thirdCatalogue = Catalogue::restoreFrom(
            new CatalogueId('cf5f781a-3f05-45cd-bbe4-f09ed61227e3'),
            'third_catalogue',
            $secondProject->getId(),
            null,
            Metadata::restoreFrom(
                Carbon::parse('2015-01-01 12:00:00'),
                Carbon::parse('2015-01-02 13:00:00'),
                true
            ),
            'third_catalogue'
        );

        $manager->persist($firstProject);
        $manager->persist($secondProject);
        $manager->persist($firstCatalogue);
        $manager->persist($secondCatalogue);
        $manager->persist($thirdCatalogue);

        $manager->flush();
    }
}
