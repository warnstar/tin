<?php

$header = <<<'EOF'
This file is part of Tin.
EOF;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'header_comment' => [
            'commentType' => 'PHPDoc',
            'header' => $header,
            'separate' => 'none'
        ],
        'array_syntax' => [
            'syntax' => 'short'
        ],
        'single_quote' => true,
        'class_attributes_separation' => true,
        'no_unused_imports' => true,
        'standardize_not_equals' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('runtime')
            ->exclude('vendor')
            ->in(__DIR__)
    )
    ->setUsingCache(false);
