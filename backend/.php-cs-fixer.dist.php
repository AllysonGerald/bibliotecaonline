<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = new Finder()
    ->ignoreDotFiles(false)
    ->ignoreVCSIgnored(true)
    ->exclude(['bootstrap/cache', 'storage', 'vendor', 'database/factories'])
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
        'no_trailing_comma_in_singleline' => true,
        'trailing_comma_in_multiline' => [
            'elements' => ['arrays', 'arguments', 'parameters'],
        ],
        'array_indentation' => true,
        'normalize_index_brace' => true,

        // Classes and namespaces
        'class_definition' => [
            'multi_line_extends_each_single_line' => true,
            'single_item_single_line' => true,
            'single_line' => true,
            'space_before_parenthesis' => true,
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
            'sort_algorithm' => 'alpha',
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
        'fully_qualified_strict_types' => true,
        'single_class_element_per_statement' => true,
        'visibility_required' => [
            'elements' => ['property', 'method', 'const'],
        ],

        // Functions and methods
        'void_return' => true,
        'return_type_declaration' => ['space_before' => 'none'],
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
            'keep_multiple_spaces_after_comma' => false,
        ],
        'type_declaration_spaces' => true,
        'nullable_type_declaration_for_default_null_value' => true,

        // Control structures
        'yoda_style' => [
            'equal' => false,
            'identical' => false,
            'less_and_greater' => false,
        ],
        'increment_style' => ['style' => 'post'],
        'control_structure_continuation_position' => [
            'position' => 'same_line',
        ],
        'control_structure_braces' => true,
        'no_unneeded_control_parentheses' => [
            'statements' => ['break', 'clone', 'continue', 'echo_print', 'return', 'switch_case', 'yield'],
        ],
        'no_unneeded_braces' => [
            'namespaces' => true,
        ],
        'no_useless_else' => true,
        'no_useless_return' => true,
        'simplified_if_return' => true,
        'switch_case_semicolon_to_colon' => true,
        'switch_case_space' => true,
        'switch_continue_to_break' => true,

        // Code quality
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_superfluous_phpdoc_tags' => [
            'allow_mixed' => true,
            'remove_inheritdoc' => true,
            'allow_unused_params' => false,
        ],
        'phpdoc_align' => ['align' => 'left'],
        'phpdoc_summary' => false,
        'phpdoc_separation' => false,
        'phpdoc_to_comment' => false,
        'phpdoc_types' => true,
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_last',
            'sort_algorithm' => 'alpha',
        ],
        'phpdoc_var_without_name' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => [
            'tokens' => [
                'break',
                'case',
                'continue',
                'curly_brace_block',
                'default',
                'extra',
                'parenthesis_brace_block',
                'return',
                'square_brace_block',
                'switch',
                'throw',
                'use',
            ],
        ],
        'class_attributes_separation' => [
            'elements' => [
                'trait_import' => 'one',
            ],
        ],
        'no_whitespace_in_blank_line' => true,
        'blank_line_after_namespace' => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => [
            'statements' => ['break', 'case', 'continue', 'declare', 'default', 'exit', 'goto', 'return', 'switch', 'throw', 'try'],
        ],

        // Laravel specific
        'method_chaining_indentation' => true,
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'new_line_for_chained_calls',
        ],

        // Modernize code
        'modernize_types_casting' => true,
        'no_alias_functions' => true,
        'no_alternative_syntax' => true,
        'no_trailing_whitespace' => true,
        'no_trailing_whitespace_in_comment' => true,
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_mixed_echo_print' => ['use' => 'echo'],
        'no_short_bool_cast' => true,
        'no_spaces_around_offset' => [
            'positions' => ['inside', 'outside'],
        ],
        'spaces_inside_parentheses' => [
            'space' => 'none',
        ],
        'no_unset_cast' => true,
        'no_useless_nullsafe_operator' => true,
        'nullable_type_declaration' => true,
        'self_static_accessor' => true,
        'single_line_comment_style' => [
            'comment_types' => ['hash'],
        ],
        'single_line_throw' => false,
        'single_quote' => [
            'strings_containing_single_quote_chars' => false,
        ],
        'standardize_not_equals' => true,
        'ternary_operator_spaces' => true,
        'ternary_to_null_coalescing' => true,
        'types_spaces' => true,
        'whitespace_after_comma_in_array' => true,

        // Clean code
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'combine_nested_dirname' => true,
        'explicit_indirect_variable' => true,
        'explicit_string_variable' => true,
        'is_null' => true,
        'no_homoglyph_names' => true,
        'no_null_property_initialization' => true,
        'no_spaces_after_function_name' => true,
        'no_unneeded_final_method' => true,
        'no_unneeded_import_alias' => true,
        'ordered_traits' => true,
        'self_accessor' => true,
        'single_line_after_imports' => true,
        'single_blank_line_at_eof' => true,
        'single_space_around_construct' => true,
        'space_after_semicolon' => true,
        // Nota: static_lambda está desabilitada para arquivos database/factories/*.php
        'static_lambda' => true,
    ])
    ->setFinder($finder)
    ->setIndent('    ')
    ->setLineEnding("\n")
;
