<?php
declare(strict_types=1);
return [
    'template' => [
        'path' => realpath(__DIR__.'/../templates')
    ],
    'translations' => ['en', 'pl'],
    'default_locale' => 'en',
    'static_pages_dir' => realpath(__DIR__.'/../data/static_pages')
];