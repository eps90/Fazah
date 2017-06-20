<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\EventListener\CommandExtractor;

use Symfony\Component\HttpFoundation\Request;

interface CommandExtractorInterface
{
    /**
     * @param Request $request
     * @param string $cmdClassName
     * @return object
     */
    public function extractFromRequest(Request $request, string $cmdClassName);
}
