<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\Repository\Impl\DataProvider;

use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Model\ValueObject\ProjectConfiguration;
use Eps\Fazah\Core\Repository\Exception\ProjectRepositoryException;
use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\Core\Repository\Query\Sorting\Sorting;
use Eps\Fazah\Core\Repository\Query\Sorting\SortSet;

trait ProjectRepositoryDataProvider
{
    public function modelIdProvider(): array
    {
        return [
            [
                'project_id' => new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                'expected' => Project::restoreFrom(
                    new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                    'my-awesome-project',
                    Metadata::restoreFrom(
                        new \DateTimeImmutable('2015-01-01 12:00:01'),
                        new \DateTimeImmutable('2015-01-02 12:00:01'),
                        true
                    ),
                    ProjectConfiguration::restoreFrom(['en', 'fr', 'pl'])
                )
            ]
        ];
    }

    public function missingModelProvider(): array
    {
        return [
            [
                'project_id' => ProjectId::generate(),
                'expected_exception' => ProjectRepositoryException::class
            ]
        ];
    }

    public function saveProvider(): array
    {
        return [
            [
                'projects' => [Project::create('my_project')]
            ],
            [
                'projects' => [
                    Project::create('my_project'),
                    Project::create('another_project')
                ]
            ]
        ];
    }

    public function findAllProvider(): array
    {
        return [
            'all' => [
                'criteria' => null,
                'expected' => [
                    Project::restoreFrom(
                        new ProjectId('9b669c76-7a80-4d3f-9191-37c1eda80a05'),
                        'disabled-project',
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:03'),
                            new \DateTimeImmutable('2015-01-02 12:00:03'),
                            false
                        ),
                        ProjectConfiguration::restoreFrom(['en', 'fr', 'pl'])
                    ),
                    Project::restoreFrom(
                        new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
                        'yet-another-cool-project',
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:02'),
                            new \DateTimeImmutable('2015-01-02 12:00:02'),
                            true
                        ),
                        ProjectConfiguration::restoreFrom(['en', 'fr', 'pl'])
                    ),
                    Project::restoreFrom(
                        new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                        'my-awesome-project',
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:01'),
                            new \DateTimeImmutable('2015-01-02 12:00:01'),
                            true
                        ),
                        ProjectConfiguration::restoreFrom(['en', 'fr', 'pl'])
                    )
                ]
            ],

            'disabled_only' => [
                'criteria' => new QueryCriteria(
                    Project::class,
                    new FilterSet(['enabled' => false])
                ),
                'expected' => [
                    Project::restoreFrom(
                        new ProjectId('9b669c76-7a80-4d3f-9191-37c1eda80a05'),
                        'disabled-project',
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:03'),
                            new \DateTimeImmutable('2015-01-02 12:00:03'),
                            false
                        ),
                        ProjectConfiguration::restoreFrom(['en', 'fr', 'pl'])
                    )
                ]
            ],

            'disabled_as_string' => [
                'criteria' => new QueryCriteria(
                    Project::class,
                    new FilterSet(['enabled' => 'false'])
                ),
                'expected' => [
                    Project::restoreFrom(
                        new ProjectId('9b669c76-7a80-4d3f-9191-37c1eda80a05'),
                        'disabled-project',
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:03'),
                            new \DateTimeImmutable('2015-01-02 12:00:03'),
                            false
                        ),
                        ProjectConfiguration::restoreFrom(['en', 'fr', 'pl'])
                    )
                ]
            ],

            'by_phrase' => [
                'criteria' => new QueryCriteria(
                    Project::class,
                    new FilterSet(['phrase' => 'awesome'])
                ),
                'expected' => [
                    Project::restoreFrom(
                        new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                        'my-awesome-project',
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:01'),
                            new \DateTimeImmutable('2015-01-02 12:00:01'),
                            true
                        ),
                        ProjectConfiguration::restoreFrom(['en', 'fr', 'pl'])
                    )
                ]
            ],

            'sort_by_updated_asc' => [
                'criteria' => new QueryCriteria(
                    Project::class,
                    null,
                    new SortSet(...[Sorting::asc('updated_at')])
                ),
                'expected' => [
                    Project::restoreFrom(
                        new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                        'my-awesome-project',
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:01'),
                            new \DateTimeImmutable('2015-01-02 12:00:01'),
                            true
                        ),
                        ProjectConfiguration::restoreFrom(['en', 'fr', 'pl'])
                    ),
                    Project::restoreFrom(
                        new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
                        'yet-another-cool-project',
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:02'),
                            new \DateTimeImmutable('2015-01-02 12:00:02'),
                            true
                        ),
                        ProjectConfiguration::restoreFrom(['en', 'fr', 'pl'])
                    ),
                    Project::restoreFrom(
                        new ProjectId('9b669c76-7a80-4d3f-9191-37c1eda80a05'),
                        'disabled-project',
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:03'),
                            new \DateTimeImmutable('2015-01-02 12:00:03'),
                            false
                        ),
                        ProjectConfiguration::restoreFrom(['en', 'fr', 'pl'])
                    )
                ],

                'mixed' => [
                    'criteria' => new QueryCriteria(
                        Project::class,
                        new FilterSet(['enabled' => true, 'project' => 'awesome']),
                        new SortSet(...[Sorting::asc('created_at')])
                    ),
                    'expected' => [
                        Project::restoreFrom(
                            new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                            'my-awesome-project',
                            Metadata::restoreFrom(
                                new \DateTimeImmutable('2015-01-01 12:00:01'),
                                new \DateTimeImmutable('2015-01-02 12:00:01'),
                                true
                            ),
                            ProjectConfiguration::restoreFrom(['en', 'fr', 'pl'])
                        ),
                        Project::restoreFrom(
                            new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
                            'yet-another-cool-project',
                            Metadata::restoreFrom(
                                new \DateTimeImmutable('2015-01-01 12:00:02'),
                                new \DateTimeImmutable('2015-01-02 12:00:02'),
                                true
                            ),
                            ProjectConfiguration::restoreFrom(['en', 'fr', 'pl'])
                        )
                    ]
                ]
            ]
        ];
    }

    public function updateProvider(): array
    {
        return [
            'disable' => [
                'input' => Project::create('my_project'),
                'process' => function (Project $project) {
                    $project->disable();
                },
                'expected' => function (Project $project) {
                    return $project->getMetadata()->isEnabled() === false;
                }
            ]
        ];
    }

    public function uniqueModelProvider(): array
    {
        return [
            [
                'models' => [
                    Project::create('project'),
                    Project::create('project')
                ]
            ]
        ];
    }

    public function removeProvider(): array
    {
        return [
            'simple' => [
                'project_id' => new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                'expected' => [
                    Project::restoreFrom(
                        new ProjectId('9b669c76-7a80-4d3f-9191-37c1eda80a05'),
                        'disabled-project',
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:03'),
                            new \DateTimeImmutable('2015-01-02 12:00:03'),
                            false
                        ),
                        ProjectConfiguration::restoreFrom(['en', 'fr', 'pl'])
                    ),
                    Project::restoreFrom(
                        new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
                        'yet-another-cool-project',
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:02'),
                            new \DateTimeImmutable('2015-01-02 12:00:02'),
                            true
                        ),
                        ProjectConfiguration::restoreFrom(['en', 'fr', 'pl'])
                    )
                ]
            ]
        ];
    }
}
