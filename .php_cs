<?php
$finder = Symfony\CS\Finder\DefaultFinder::create();
$config = Symfony\CS\Config\Config::create();
$config->fixers(
    array(
        'indentation',
        'linefeed',
        'trailing_spaces',
        'short_tag',
        'visibility',
        'php_closing_tag',
        'braces',
        'function_declaration',
        'psr0',
        'elseif',
        'eof_ending',
        'unused_use',
        'phpdoc_indent',
        'multiline_array_trailing_comma',
        '-no_empty_lines_after_phpdocs',
        '-single_blank_line_before_namespace',
        '-blankline_after_open_tag',
        '-single_quote',
        '-phpdoc_scalar'
    )
);
$config->finder($finder);
return $config;
