<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([__DIR__ . '/src', __DIR__ . '/app'])
    ->exclude(['vendor'])
    ->name('*.php');

return new Config()
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'declare_strict_types' => true,
        'no_unused_imports' => true,
        'ordered_imports' => true,
        'simplified_if_return' => true,
        'simplified_null_return' => true,
        'no_alternative_syntax' => true,
        'blank_line_before_statement' => ['statements' => ['return', 'throw', 'try']],
        'phpdoc_order' => true,
        'no_superfluous_phpdoc_tags' => true,
        'phpdoc_scalar' => true,
        'phpdoc_types_order' => true,
        'strict_param' => true,
        'phpdoc_separation' => true,
        'phpdoc_trim' => true,
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setUsingCache(true);