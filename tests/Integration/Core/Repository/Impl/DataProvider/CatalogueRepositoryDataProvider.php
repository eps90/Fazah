<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\Repository\Impl\DataProvider;

use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Repository\Exception\CatalogueRepositoryException;
use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\Core\Repository\Query\Sorting\Sorting;
use Eps\Fazah\Core\Repository\Query\Sorting\SortSet;

trait CatalogueRepositoryDataProvider
{
    public function modelIdProvider(): array
    {
        return [
            [
                'catalogue_id' => new CatalogueId('3df07fa8-80fa-4d5d-a0cb-9bcf3d830425'),
                'expected' => Catalogue::restoreFrom(
                    new CatalogueId('3df07fa8-80fa-4d5d-a0cb-9bcf3d830425'),
                    'second-catalogue',
                    new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                    null,
                    Metadata::restoreFrom(
                        new \DateTimeImmutable('2015-01-01 12:00:01'),
                        new \DateTimeImmutable('2015-01-02 12:00:01'),
                        true
                    )
                )
            ]
        ];
    }

    public function missingModelProvider(): array
    {
        return [
            [
                'catalogue_id' => CatalogueId::generate(),
                'expected_exception' => CatalogueRepositoryException::class
            ]
        ];
    }

    public function saveProvider(): array
    {
        return [
            [
                'catalogues' => [
                    Catalogue::restoreFrom(
                        CatalogueId::generate(),
                        'my-saved-catalogue',
                        new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2017-01-01 12:00:01'),
                            new \DateTimeImmutable('2017-01-02 12:00:01'),
                            true
                        )
                    )
                ]
            ],
            [
                'catalogues' => [
                    Catalogue::create('My catalogue', new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260')),
                    Catalogue::create('Another catalogue', new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'))
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
                    Catalogue::restoreFrom(
                        new CatalogueId('5a53c071-f518-41af-9b94-71044b1d5a1f'),
                        'fifth-catalogue',
                        new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:04'),
                            new \DateTimeImmutable('2015-01-02 12:00:04'),
                            false
                        )
                    ),
                    Catalogue::restoreFrom(
                        new CatalogueId('8094de70-b269-4ea3-a11c-4d43a5218b23'),
                        'forth-catalogue',
                        new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:03'),
                            new \DateTimeImmutable('2015-01-02 12:00:03'),
                            true
                        )
                    ),
                    Catalogue::restoreFrom(
                        new CatalogueId('b21deaae-8078-45e7-a83c-47a72e8d0458'),
                        'third-catalogue',
                        new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:02'),
                            new \DateTimeImmutable('2015-01-02 12:00:02'),
                            true
                        )
                    ),
                    Catalogue::restoreFrom(
                        new CatalogueId('3df07fa8-80fa-4d5d-a0cb-9bcf3d830425'),
                        'second-catalogue',
                        new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:01'),
                            new \DateTimeImmutable('2015-01-02 12:00:01'),
                            true
                        )
                    ),
                    Catalogue::restoreFrom(
                        new CatalogueId('a853f467-403d-416b-8269-36369c34d723'),
                        'first-catalogue',
                        new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:00'),
                            new \DateTimeImmutable('2015-01-02 12:00:00'),
                            true
                        )
                    )
                ]
            ],

            'by_project_id' => [
                'criteria' => new QueryCriteria(
                    Catalogue::class,
                    new FilterSet([
                        'project_id' => new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260')
                    ])
                ),
                'expected' => [
                    Catalogue::restoreFrom(
                        new CatalogueId('b21deaae-8078-45e7-a83c-47a72e8d0458'),
                        'third-catalogue',
                        new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:02'),
                            new \DateTimeImmutable('2015-01-02 12:00:02'),
                            true
                        )
                    ),
                    Catalogue::restoreFrom(
                        new CatalogueId('3df07fa8-80fa-4d5d-a0cb-9bcf3d830425'),
                        'second-catalogue',
                        new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:01'),
                            new \DateTimeImmutable('2015-01-02 12:00:01'),
                            true
                        )
                    ),
                    Catalogue::restoreFrom(
                        new CatalogueId('a853f467-403d-416b-8269-36369c34d723'),
                        'first-catalogue',
                        new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:00'),
                            new \DateTimeImmutable('2015-01-02 12:00:00'),
                            true
                        )
                    )
                ]
            ],

            'by_enabled' => [
                'criteria' => new QueryCriteria(
                    Catalogue::class,
                    new FilterSet(['enabled' => false])
                ),
                'expected' => [
                    Catalogue::restoreFrom(
                        new CatalogueId('5a53c071-f518-41af-9b94-71044b1d5a1f'),
                        'fifth-catalogue',
                        new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:04'),
                            new \DateTimeImmutable('2015-01-02 12:00:04'),
                            false
                        )
                    )
                ]
            ],

            'by_phrase' => [
                'criteria' => new QueryCriteria(
                    Catalogue::class,
                    new FilterSet(['phrase' => 'forth'])
                ),
                'expected' => [
                    Catalogue::restoreFrom(
                        new CatalogueId('8094de70-b269-4ea3-a11c-4d43a5218b23'),
                        'forth-catalogue',
                        new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:03'),
                            new \DateTimeImmutable('2015-01-02 12:00:03'),
                            true
                        )
                    )
                ]
            ],

            'sort_by_updated' => [
                'criteria' => new QueryCriteria(
                    Catalogue::class,
                    null,
                    new SortSet(...[Sorting::asc('updated_at')])
                ),
                'expected' => [
                    Catalogue::restoreFrom(
                        new CatalogueId('a853f467-403d-416b-8269-36369c34d723'),
                        'first-catalogue',
                        new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:00'),
                            new \DateTimeImmutable('2015-01-02 12:00:00'),
                            true
                        )
                    ),
                    Catalogue::restoreFrom(
                        new CatalogueId('3df07fa8-80fa-4d5d-a0cb-9bcf3d830425'),
                        'second-catalogue',
                        new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:01'),
                            new \DateTimeImmutable('2015-01-02 12:00:01'),
                            true
                        )
                    ),
                    Catalogue::restoreFrom(
                        new CatalogueId('b21deaae-8078-45e7-a83c-47a72e8d0458'),
                        'third-catalogue',
                        new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:02'),
                            new \DateTimeImmutable('2015-01-02 12:00:02'),
                            true
                        )
                    ),
                    Catalogue::restoreFrom(
                        new CatalogueId('8094de70-b269-4ea3-a11c-4d43a5218b23'),
                        'forth-catalogue',
                        new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:03'),
                            new \DateTimeImmutable('2015-01-02 12:00:03'),
                            true
                        )
                    ),
                    Catalogue::restoreFrom(
                        new CatalogueId('5a53c071-f518-41af-9b94-71044b1d5a1f'),
                        'fifth-catalogue',
                        new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:04'),
                            new \DateTimeImmutable('2015-01-02 12:00:04'),
                            false
                        )
                    )
                ]
            ],

            'mixed' => [
                'criteria' => new QueryCriteria(
                    Catalogue::class,
                    new FilterSet(['enabled' => true]),
                    new SortSet(...[Sorting::asc('created_at')])
                ),
                'expected' => [
                    Catalogue::restoreFrom(
                        new CatalogueId('a853f467-403d-416b-8269-36369c34d723'),
                        'first-catalogue',
                        new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:00'),
                            new \DateTimeImmutable('2015-01-02 12:00:00'),
                            true
                        )
                    ),
                    Catalogue::restoreFrom(
                        new CatalogueId('3df07fa8-80fa-4d5d-a0cb-9bcf3d830425'),
                        'second-catalogue',
                        new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:01'),
                            new \DateTimeImmutable('2015-01-02 12:00:01'),
                            true
                        )
                    ),
                    Catalogue::restoreFrom(
                        new CatalogueId('b21deaae-8078-45e7-a83c-47a72e8d0458'),
                        'third-catalogue',
                        new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:02'),
                            new \DateTimeImmutable('2015-01-02 12:00:02'),
                            true
                        )
                    ),
                    Catalogue::restoreFrom(
                        new CatalogueId('8094de70-b269-4ea3-a11c-4d43a5218b23'),
                        'forth-catalogue',
                        new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:03'),
                            new \DateTimeImmutable('2015-01-02 12:00:03'),
                            true
                        )
                    )
                ]
            ]
        ];
    }

    public function updateProvider(): array
    {
        return [
            'disable' => [
                'input' => Catalogue::create(
                    'catalogue name',
                    ProjectId::generate()
                ),
                'process' => function (Catalogue $catalogue) {
                    $catalogue->disable();
                },
                'expect' => function (Catalogue $catalogue) {
                    return $catalogue->getMetadata()->isEnabled() === false;
                }
            ]
        ];
    }

    public function uniqueModelProvider(): array
    {
        return [
            [
                'models' => [
                    Catalogue::create('my.catalogue', new ProjectId('29e80c6e-dd58-40b1-9cdf-f70be9776cec')),
                    Catalogue::create('my.catalogue', new ProjectId('29e80c6e-dd58-40b1-9cdf-f70be9776cec')),
                ]
            ]
        ];
    }

    public function removeProvider(): array
    {
        return [
            'simple' => [
                'catalogue_id' => new CatalogueId('a853f467-403d-416b-8269-36369c34d723'),
                'expected' => [
                    Catalogue::restoreFrom(
                        new CatalogueId('5a53c071-f518-41af-9b94-71044b1d5a1f'),
                        'fifth-catalogue',
                        new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:04'),
                            new \DateTimeImmutable('2015-01-02 12:00:04'),
                            false
                        )
                    ),
                    Catalogue::restoreFrom(
                        new CatalogueId('8094de70-b269-4ea3-a11c-4d43a5218b23'),
                        'forth-catalogue',
                        new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:03'),
                            new \DateTimeImmutable('2015-01-02 12:00:03'),
                            true
                        )
                    ),
                    Catalogue::restoreFrom(
                        new CatalogueId('b21deaae-8078-45e7-a83c-47a72e8d0458'),
                        'third-catalogue',
                        new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:02'),
                            new \DateTimeImmutable('2015-01-02 12:00:02'),
                            true
                        )
                    ),
                    Catalogue::restoreFrom(
                        new CatalogueId('3df07fa8-80fa-4d5d-a0cb-9bcf3d830425'),
                        'second-catalogue',
                        new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                        null,
                        Metadata::restoreFrom(
                            new \DateTimeImmutable('2015-01-01 12:00:01'),
                            new \DateTimeImmutable('2015-01-02 12:00:01'),
                            true
                        )
                    )
                ]
            ],

        ];
    }
}
