<?php
/**
 * @file
 * Master configuration file. This should be included first.
 */
global $registry, $argv, $argvOffset;

$registry->route('help', "Show the help text")
  ->does('\Fortissimo\CLI\ShowHelp');

$registry->route('about', "Display information about the Markdown Extra CLI.")
  ->does('\mattfarina\MarkdownExtra\About', 'helpText')
  ->does('\Fortissimo\CLI\IO\Write')
    ->using('text')->from('cxt:helpText');
