<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Catalogue;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Req2CmdBundle\Command\DeserializableCommandInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ChangeCatalogueState implements DeserializableCommandInterface
{
    /**
     * @var CatalogueId
     */
    private $catalogueId;

    /**
     * @var bool
     */
    private $shouldBeEnabled;

    public function __construct(CatalogueId $catalogueId, bool $shouldBeEnabled)
    {
        $this->catalogueId = $catalogueId;
        $this->shouldBeEnabled = $shouldBeEnabled;
    }

    /**
     * @return CatalogueId
     */
    public function getCatalogueId(): CatalogueId
    {
        return $this->catalogueId;
    }

    /**
     * @return bool
     */
    public function shouldBeEnabled(): bool
    {
        return $this->shouldBeEnabled;
    }

    public static function fromArray(array $commandProps): self
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired(['catalogue_id', 'enabled']);
        $props = $resolver->resolve($commandProps);

        return new self(
            new CatalogueId((string)$props['catalogue_id']),
            (bool)$props['enabled']
        );
    }
}
