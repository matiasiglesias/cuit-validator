<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('vendor')
    ->notName('autoload_classmap.php')
    ->notName('autoload_function.php')
    ->notName('LICENSE')
    ->notName('.php_cs')
    ->notName('composer.*')
    ->notName('*.md')
    ->notName('*.xml')
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces' => true,
        'blank_line_before_return' => true,
        'braces' => true,
        //'no_empty_phpdoc' => true,
        'no_unused_imports' => true,
        'self_accessor' => true,
        'single_blank_line_before_namespace' => true,
        'standardize_not_equals' => true,
        'ternary_operator_spaces' => true,
        'whitespace_after_comma_in_array' => true,
    ])
    ->setFinder($finder)
;
