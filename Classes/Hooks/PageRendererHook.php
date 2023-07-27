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

class PageRendererHook
{
    /**
     * Add external hosts to the HTML-header for DNS-refetching
     * https://www.w3.org/TR/resource-hints/#dns-prefetch
     *
     * @param array $params
     * @param PageRenderer $pageRenderer
     */
    public function renderPostTransform(array $params, PageRenderer $pageRenderer): void
    {
        if (
            ($GLOBALS['TYPO3_REQUEST'] ?? null) instanceof ServerRequestInterface
            && ApplicationType::fromRequest($GLOBALS['TYPO3_REQUEST'])->isFrontend()
        ) {
            // Iterate through resources
            foreach ($params as $key => $resources) {
                switch ($key) {
                    case 'jsLibs':
                    case 'jsFooterLibs':
                    case 'jsFiles':
                    case 'jsFooterFiles':
                    case 'cssLibs':
                    case 'cssFiles':
                        $hosts = $this->getHosts($resources);
                        foreach (array_unique($hosts) as $host) {
                            $pageRenderer->addHeaderData('<link rel="dns-prefetch" href="//' . $host . '">');
                        }
                        break;
                }
            }
        }
    }

    /**
     * Iterate through files and check if they are local or external.
     *
     * @param array $file
     *
     * @return array
     */
    private function getHosts(array $file): array
    {
        $hosts = [];
        foreach ($file as $config) {
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
