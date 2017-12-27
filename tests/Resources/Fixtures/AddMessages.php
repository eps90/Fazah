<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Resources\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Model\ValueObject\Translation;

final class AddMessages extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $messageUuids = [
            'b5bce595-58d2-4023-89ab-df08b5c10e95',
            'ec2adbdd-505d-4055-a081-124d38e8c70d',
            '6ffa7d14-0b67-4420-9266-6d60228707c6',
            '25cb42c9-74bc-436e-801b-2a40b191a7f2',
            '31902865-518e-4504-95f9-0745738c5c4d',
            '3fda00fd-a1c8-488c-ba3d-f15addd39354',
            '9c87ee26-ed1f-42f1-a417-359f8b1c2971',
            '46f334ec-9e80-44dd-be7f-c8cb0fbfb790',
            '6932339c-c274-4b26-8225-b69974909453',
            '28f520fa-9e04-4be7-a0ae-e685ee49adb4',
            '9c595129-8ba9-4eee-a0f5-9de0ef423fab',
            '7a2fc32d-a44c-4ce6-baae-8b4ee8196b92',
            '0dbabc2a-93e3-4895-94be-913c0a6320a2',
            '09d55f8b-4567-45e8-b9a0-0ce2ad2e7281',
            '15c24a9a-0dd6-4294-a4c5-7cd18699dbc7',
            'dcc401b3-d293-4f7b-8885-9346c5b4a5e7',
            'd4044603-9370-49af-bd1d-a6a9f6857118',
            'fbedb377-c373-4f67-b115-7fb21fc51cd8',
            '854079fa-d1a1-4fbe-8ecc-a09065bfed2e',
            '4241d0ba-a6a7-43d0-819b-02b9bdb428a7',
            '94e05d2e-4173-4928-9681-faa79c15e9ef',
            '01892f4a-e15a-44b6-a3e8-03441d94d902',
            'a9933d3c-d35f-482e-9b8a-3be629936f36',
            '0ec85c11-5153-4de9-b44c-442cb8f57a88',
            'd1c70ed4-8d45-4b55-a2c6-3914726276b2',
            'bdd09c50-cf76-44cf-a00a-984db2a17914',
            '28cf1cb1-98b1-4ced-9d35-ba5a885886da',
            '80c7d236-f5a6-4ed0-89c4-8626a9ae04c6',
            'bd0797c9-eaf8-4483-9446-3acced359a2b',
            '8e8a8526-4516-41e0-b1ca-f13cb5a693b9',
            'e2d8d2f2-7926-4a9f-b5df-1e1c54160867',
            '0d10a791-9fdf-4cdf-ab20-9321da2d7e01',
            '1ada5bb5-8f50-4699-9c59-f9a1e5b55d6b'
        ];
        /** @var Catalogue[] $catalogues */
        $catalogues = [
            $this->getReference('catalogue-0'),
            $this->getReference('catalogue-0'),
            $this->getReference('catalogue-0'),
            $this->getReference('catalogue-1'),
            $this->getReference('catalogue-2'),
            $this->getReference('catalogue-2'),
            $this->getReference('catalogue-2'),
            $this->getReference('catalogue-2'),
            $this->getReference('catalogue-3'),
            $this->getReference('catalogue-3'),
            $this->getReference('catalogue-3')
        ];
        $languages = ['fr', 'pl', 'en'];
        $enabled = array_merge(array_fill(0, 3, false), array_fill(0, 30, true));

        foreach ($catalogues as $idx => $catalogue) {
            $messageKey = "test.message.$idx";
            foreach ($languages as $langIdx => $language) {
                $translatedMessage = "Hello from message #$idx in language $language!";
                $messageIdx = array_pop($messageUuids);

                $timeSeconds = str_pad((string)count($messageUuids), 2, '0');
                $metadata = Metadata::restoreFrom(
                    (new \DateTimeImmutable('2015-01-01 12:00:00'))
                        ->add(new \DateInterval("PT{$timeSeconds}S")),
                    (new \DateTimeImmutable('2015-01-02 12:00:00'))
                        ->add(new \DateInterval("PT{$timeSeconds}S")),
                    array_pop($enabled)
                );
                $message = Message::restoreFrom(
                    new MessageId($messageIdx),
                    Translation::create(
                        $messageKey,
                        $translatedMessage,
                        $language
                    ),
                    $catalogue->getId(),
                    $metadata
                );
                $manager->persist($message);
            }
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
