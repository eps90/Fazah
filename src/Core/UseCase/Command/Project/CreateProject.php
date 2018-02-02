<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Project;

use Eps\Req2CmdBundle\Command\DeserializableCommandInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CreateProject implements DeserializableCommandInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string[]
     */
    private $availableLanguages;

    public function __construct(string $name, array $availableLanguages = [])
    {
        $this->name = $name;
        $this->availableLanguages = $availableLanguages;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function getAvailableLanguages(): array
    {
        return $this->availableLanguages;
    }

    /**
     * @param array $properties
     * @return CreateProject
     * @throws \Symfony\Component\OptionsResolver\Exception\ExceptionInterface
     */
    public static function fromArray(array $properties): self
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired(['name'])
            ->setAllowedTypes('name', 'string')
            ->setDefault('available_languages', [])
            ->setAllowedTypes('available_languages', 'array');

        $finalProperties = $resolver->resolve($properties);

        return new self((string)$finalProperties['name'], $finalProperties['available_languages']);
    }
}
