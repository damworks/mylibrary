<?php

use Pimcore\Bundle\ApplicationLoggerBundle\PimcoreApplicationLoggerBundle;
use Pimcore\Bundle\QuillBundle\PimcoreQuillBundle;

return [
    Pimcore\Bundle\SimpleBackendSearchBundle\PimcoreSimpleBackendSearchBundle::class => ['all' => true],
    PimcoreQuillBundle::class => ['all' => true],
    PimcoreApplicationLoggerBundle::class => ['all' => true],

];
