<?php
/**
 * @file
 * Master configuration file. This should be included first.
 */
global $registry, $argv, $argvOffset;

$registry->route('help', "Show the help text")
  ->does('\Fortissimo\CLI\ShowHelp');

$registry->route('about', "Display information about the Markdown Extra CLI.")
  ->does('\Fortissimo\CLI\Update\GetVersionFromTextFile', 'version')
    ->using('file', FORT_APP_PATH .'/VERSION')
  ->does('\mattfarina\MarkdownExtra\About', 'helpText')
    ->using('version')->from('cxt:version')
  ->does('\Fortissimo\CLI\IO\Write')
    ->using('text')->from('cxt:helpText');
