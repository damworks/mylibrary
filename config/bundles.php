<?php

use Elements\Bundle\ProcessManagerBundle\ElementsProcessManagerBundle;
use Pimcore\Bundle\ApplicationLoggerBundle\PimcoreApplicationLoggerBundle;
use Pimcore\Bundle\DataHubBundle\PimcoreDataHubBundle;
use Pimcore\Bundle\QuillBundle\PimcoreQuillBundle;

return [
    Pimcore\Bundle\SimpleBackendSearchBundle\PimcoreSimpleBackendSearchBundle::class => ['all' => true],
    PimcoreQuillBundle::class => ['all' => true],
    PimcoreApplicationLoggerBundle::class => ['all' => true],
    PimcoreDataHubBundle::class => ['all' => true],
    ElementsProcessManagerBundle::class => ['all' => true]
];
