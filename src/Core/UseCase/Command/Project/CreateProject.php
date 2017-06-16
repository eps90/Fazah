<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Project;

use Eps\Fazah\Core\UseCase\Command\SerializableCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CreateProject implements SerializableCommand
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public static function fromArray(array $properties): self
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired(['name']);

        $finalProperties = $resolver->resolve($properties);

        return new self((string)$finalProperties['name']);
    }
}
