<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'DNS-Prefetch',
    'description' => 'Adds external hosts to the HTML-header for DNS-refetching.',
    'category' => 'fe',
    'state' => 'stable',
    'clearcacheonload' => true,
    'author' => 'Stephan Kellermayr',
    'author_email' => 'typo3@quellenform.at',
    'author_company' => 'Kellermayr KG',
    'version' => '1.0.1',
    'constraints' => [
        'depends' => [
            'php' => '7.2.0-8.4.99',
            'typo3' => '10.4.0-12.5.99',
        ],
        'conflicts' => [],
        'suggests' => []
    ],
    'autoload' => [
        'psr-4' => ['Quellenform\\Resourcehints\\' => 'Classes']
    ],
];
