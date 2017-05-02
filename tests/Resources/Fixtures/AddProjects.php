<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Resources\Fixtures;

use Carbon\Carbon;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Project;

final class AddProjects extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $firstProject = Project::restoreFrom(
            new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
            'my-awesome-project',
            Carbon::instance(new \DateTime('2015-01-01 12:00:01')),
            Carbon::instance(new \DateTime('2015-01-02 12:00:01')),
            true
        );
        $manager->persist($firstProject);

        $secondProject = Project::restoreFrom(
            new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
            'yet-another-cool-project',
            Carbon::instance(new \DateTime('2015-01-01 12:00:02')),
            Carbon::instance(new \DateTime('2015-01-02 12:00:02')),
            true
        );
        $manager->persist($secondProject);

        $manager->flush();

        $this->addReference('first-project', $firstProject);
        $this->addReference('second-project', $secondProject);
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
