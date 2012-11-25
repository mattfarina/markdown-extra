<?php
/**
 * @file
 * Master configuration file. This should be included first.
 */
global $registry, $argv, $argvOffset;

$registry->route('help', "Show the help text")
  ->does('\Fortissimo\CLI\ShowHelp')
  ;

$registry->route('update', 'Update the application if there is a newer version available.')
  ->does('\Fortissimo\CLI\Update\GetVersionFromTextFile', 'version1')
    ->using('file', FORT_APP_PATH .'/VERSION')
  ->does('\Fortissimo\CLI\Update\GetVersionFromTextFile', 'version2')
    ->using('file', 'https://raw.github.com/mattfarina/markdown-extra/master/VERSION')
  ->does('\Fortissimo\CLI\Update\CompareVersions', 'versionDiff')
    ->using('version1')->from('cxt:version1')
    ->using('version2')->from('cxt:version2')
  ;

$registry->route('about', "Display information about the Markdown Extra CLI.")
  ->does('\Fortissimo\CLI\Update\GetVersionFromTextFile', 'version')
    ->using('file', FORT_APP_PATH .'/VERSION')
  ->does('\mattfarina\MarkdownExtra\About', 'helpText')
    ->using('version')->from('cxt:version')
  ->does('\Fortissimo\CLI\IO\Write')
    ->using('text')->from('cxt:helpText')
  ;
