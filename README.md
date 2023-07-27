[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg?style=for-the-badge)](https://www.paypal.me/quellenform)
[![Latest Stable Version](https://img.shields.io/packagist/v/quellenform/t3x-resourcehints?style=for-the-badge)](https://packagist.org/packages/quellenform/t3x-resourcehints)
[![TYPO3 10](https://img.shields.io/badge/TYPO3-10-%23f49700.svg?style=for-the-badge)](https://get.typo3.org/version/10)
[![TYPO3 11](https://img.shields.io/badge/TYPO3-11-%23f49700.svg?style=for-the-badge)](https://get.typo3.org/version/11)
[![TYPO3 12](https://img.shields.io/badge/TYPO3-12-%23f49700.svg?style=for-the-badge)](https://get.typo3.org/version/12)
[![License](https://img.shields.io/packagist/l/quellenform/t3x-resourcehints?style=for-the-badge)](https://packagist.org/packages/quellenform/t3x-resourcehints)

# Resource Hints

TYPO3 CMS Extension "resourcehints"

## What does it do?

This Extensions adds external hosts to the HTML-header for DNS-refetching.
It simple adds "dns-prefetch" to the header by iterating through existing Resources of the type:
- jsLibs
- jsFooterLibs
- jsFiles
- jsFooterFiles
- cssLibs
- cssFiles

This task is done via a PageRenderHook. Simple.

Read more: [Resource Hints - What is Preload, Prefetch, and Preconnect?](https://www.keycdn.com/blog/resource-hints)

## Installation/Configuration

1. Install extension with composer or directly from TER/git
