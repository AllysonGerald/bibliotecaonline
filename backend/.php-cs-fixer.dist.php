<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = new Finder()
    ->ignoreDotFiles(false)
    ->ignoreVCSIgnored(true)
    ->exclude(['bootstrap/cache', 'storage', 'vendor'])
    ->notPath('_ide_helper.php')
    ->in(__DIR__)
;

return new Config()
    ->setRiskyAllowed(true)
    ->setRules([
        // PSR Standards
        '@PSR12' => true,
        '@Symfony' => true,
        '@PHP84Migration' => true,
        'psr_autoloading' => true,

        // Strict types
        'declare_strict_types' => true,

        // Arrays
        'array_syntax' => ['syntax' => 'short'],
        'trim_array_spaces' => true,
        'no_whitespace_before_comma_in_array' => true,

        // Classes and namespaces
        'class_definition' => [
            'multi_line_extends_each_single_line' => true,
            'single_item_single_line' => true,
            'single_line' => true,
        ],
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'case',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public',
                'property_protected',
                'property_private',
                'construct',
                'destruct',
                'magic',
                'phpunit',
                'method_public',
                'method_protected',
                'method_private',
            ],
        ],
        'ordered_imports' => [
            'imports_order' => ['class', 'function', 'const'],
            'sort_algorithm' => 'alpha',
        ],
        'no_unused_imports' => true,
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => true,
        ],

        // Functions and methods
        'void_return' => true,
        'return_type_declaration' => ['space_before' => 'none'],
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
        ],

        // Control structures
        'yoda_style' => [
            'equal' => false,
            'identical' => false,
            'less_and_greater' => false,
        ],
        'increment_style' => ['style' => 'post'],

        // Code quality
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_superfluous_phpdoc_tags' => [
            'allow_mixed' => true,
            'remove_inheritdoc' => true,
        ],
        'phpdoc_align' => ['align' => 'left'],
        'phpdoc_summary' => false,
        'phpdoc_separation' => false,
        'phpdoc_to_comment' => false,

        // Laravel specific
        'method_chaining_indentation' => true,
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'new_line_for_chained_calls',
        ],

        // Modernize code
        'modernize_types_casting' => true,
        'no_alias_functions' => true,
        'no_alternative_syntax' => true,

        // Clean code
        'no_useless_else' => true,
        'no_useless_return' => true,
        'simplified_if_return' => true,
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
    ])
    ->setFinder($finder)
;
