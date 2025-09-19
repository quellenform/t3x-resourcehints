<?php

declare(strict_types=1);

namespace Quellenform\Resourcehints\Hooks;

/*
 * This file is part of the "resourcehints" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\ApplicationType;
use TYPO3\CMS\Core\Page\PageRenderer;

/**
 * PageRendererHook
 */
final class PageRendererHook
{
    /**
     * PostTransform for manipulation of concatenated and compressed files
     *
     * @param array $params
     * @param PageRenderer $pageRenderer
     *
     * @return void
     */
    public function renderPostTransform(array $params, PageRenderer $pageRenderer): void
    {
        if (
            ($GLOBALS['TYPO3_REQUEST'] ?? null) instanceof ServerRequestInterface
            && ApplicationType::fromRequest($GLOBALS['TYPO3_REQUEST'])->isFrontend()
        ) {
            $this->iterateThroughResources($params, $pageRenderer);
        }
    }

    /**
     * Add external hosts to the HTML-header for DNS-refetching
     * https://www.w3.org/TR/resource-hints/#dns-prefetch
     *
     * @param array $params
     * @param PageRenderer $pageRenderer
     *
     * @return void
     */
    private function iterateThroughResources(array $params, PageRenderer $pageRenderer): void
    {
        foreach ($params as $key => $resources) {
            switch ($key) {
                case 'jsLibs':
                case 'jsFooterLibs':
                case 'jsFiles':
                case 'jsFooterFiles':
                case 'cssLibs':
                case 'cssFiles':
                    $hosts = $this->getHostsFromResources($resources);
                    foreach (array_unique($hosts) as $host) {
                        $pageRenderer->addHeaderData('<link rel="dns-prefetch" href="//' . $host . '">');
                    }
                    break;
            }
        }
    }

    /**
     * Iterate through files and check if they are local or external.
     *
     * @param array $files
     *
     * @return array
     */
    private function getHostsFromResources(array $files): array
    {
        $hosts = [];
        foreach ($files as $config) {
            if (
                substr($config['file'], 0, 2) !== '//' ||
                substr($config['file'], 0, 4) !== 'http'
            ) {
                $parsedUrl = parse_url($config['file']);
                if (!empty($parsedUrl['host'])) {
                    $hosts[] = $parsedUrl['host'];
                }
            }
        }
        return $hosts;
    }
}
