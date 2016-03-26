<?php

/**
 * php-cs-fixer - configuration file
 */

$header = <<<EOF
WPИ-XM Server Stack
Copyright © 2010 - 2016, Jens-André Koch <jakoch@web.de>
http://wpn-xm.org/

This source file is subject to the terms of the MIT license.
For full copyright and license information, view the bundled LICENSE file.
EOF;

$finder = PhpCsFixer\Finder::create()
    ->ignoreVCS(true)
    ->files()
    ->name('*.php')
    ->notName('.php_cs')
    ->notName('AllTests.php')
    ->notName('composer.*')
    ->notName('*.phar')
    ->notName('*.ico')
    ->notName('*.ttf')
    ->notName('*.gif')
    ->notName('*.swf')
    ->notName('*.jpg')
    ->notName('*.png')
    ->notName('*.exe')
    ->notName('wpnxm-software-registry.php')
    ->exclude('Fixtures')
    ->exclude('vendor')
    ->exclude('registry') // registry is JSON pretty printed in its own short format
    ->exclude('nbproject') // netbeans project files
    ->in(__DIR__);
;

return PhpCsFixer\Config::create()
    ->setUsingCache(true)
    ->setRiskyAllowed(true)
    ->setRules(array(
        '@PSR2' => true,
        'align_double_arrow' => true,
        'align_equals' => true,
        'binary_operator_spaces' => true,
        'blank_line_before_return' => true,
        'concat_without_spaces' => true,
        'header_comment' => array('header' => $header),
        'include' => true,
        'short_array_syntax' => true,
        'lowercase_cast' => true,
        'method_separation' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_blank_lines_between_uses' => true,
        'no_duplicate_semicolons' => true,
        'no_extra_consecutive_blank_lines' => true,
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_unused_imports' => true,
        'object_operator_without_whitespace' => true,
        'ordered_imports' => true,
        'phpdoc_align' => true,
        'phpdoc_indent' => true,
        'phpdoc_no_access' => true,
        'phpdoc_no_package' => true,
        'phpdoc_order' => true,
        'phpdoc_scalar' => true,
        'phpdoc_trim' => true,
        'phpdoc_type_to_var' => true,
        'psr0' => true,
        'single_blank_line_before_namespace' => true,
        'single_quote' => true,
        'spaces_cast' => true,
        'standardize_not_equals' => true,
        'ternary_operator_spaces' => true,
        'trailing_comma_in_multiline_array' => true,
        'function_typehint_space' => true
    ))
    ->finder($finder)
;