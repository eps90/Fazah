<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\EventListener\CommandExtractor;

use Eps\Fazah\FazahBundle\EventListener\CommandExtractor\MockCommandExtractor;
use Eps\Fazah\Tests\Resources\Fixtures\SerializableCommand\DummySerializableCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class MockCommandExtractorTest extends TestCase
{
    /**
     * @var MockCommandExtractor
     */
    private $extractor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extractor = new MockCommandExtractor();
    }

    /**
     * @test
     */
    public function itShouldReturnPreviouslySetCommandToReturn(): void
    {
        $someCommand = new DummySerializableCommand('my command', []);
        $this->extractor->willReturn($someCommand);
        $request = new Request();

        $expectedResult = $someCommand;
        $actualResult = $this->extractor->extractFromRequest($request, DummySerializableCommand::class);

        static::assertEquals($expectedResult, $actualResult);
    }
}
