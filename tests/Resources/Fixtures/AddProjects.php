<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Resources\Fixtures;

use Carbon\Carbon;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Model\ValueObject\Metadata;

final class AddProjects extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $firstProjectMeta = Metadata::restoreFrom(
            Carbon::instance(new \DateTime('2015-01-01 12:00:01')),
            Carbon::instance(new \DateTime('2015-01-02 12:00:01')),
            true
        );
        $firstProject = Project::restoreFrom(
            new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
            'my-awesome-project',
            $firstProjectMeta
        );
        $manager->persist($firstProject);

        $secondProjectMeta = Metadata::restoreFrom(
            Carbon::instance(new \DateTime('2015-01-01 12:00:02')),
            Carbon::instance(new \DateTime('2015-01-02 12:00:02')),
            true
        );
        $secondProject = Project::restoreFrom(
            new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
            'yet-another-cool-project',
            $secondProjectMeta
        );
        $manager->persist($secondProject);

        $disabledProjectMeta = Metadata::restoreFrom(
            Carbon::parse('2015-01-01 12:00:03'),
            Carbon::parse('2015-01-02 12:00:03'),
            false
        );
        $disabledProject = Project::restoreFrom(
            new ProjectId('9b669c76-7a80-4d3f-9191-37c1eda80a05'),
            'disabled-project',
            $disabledProjectMeta
        );
        $manager->persist($disabledProject);

        $manager->flush();

        $this->addReference('first-project', $firstProject);
        $this->addReference('second-project', $secondProject);
        $this->addReference('disabled-project', $disabledProject);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 0;
    }
}
