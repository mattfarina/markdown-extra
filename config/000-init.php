<?php
/**
 * @file
 * Master configuration file. This should be included first.
 */
global $registry, $argv, $argvOffset;

$registry->route('help', "Show the help text")
  ->does('\Fortissimo\CLI\ShowHelp')
  ;

$registry->route('convert', 'Convert markdown extra to html using standard in and out.')
  ->does('\Fortissimo\CLI\SetupOptions', 'CliOptions')
  ->does('\mattfarina\MarkdownExtra\ConvertOptions')
    ->using('inputDefinition')->from('cxt:CliOptions')
  ->does('\Fortissimo\CLI\ParseOptions', 'opts')
    ->using('help', 'Copy an object to object storage.')
    ->using('usage', '<comment>Usage:</comment> ' . $argv[0]. ' convert [--OPTIONS]')
    ->using('optionSpec')->from('cxt:CliOptions')
    ->using('options', $argv)
  ->does('\mattfarina\MarkdownExtra\GetMarkdown', 'markdown')
    ->using('file')->from('cxt:file')
  ->does('\mattfarina\MarkdownExtra\Convert', 'html')
    ->using('markdown')->from('cxt:markdown')
  ->does('\mattfarina\MarkdownExtra\WriteOutput')
    ->using('text')->from('cxt:html')
    ->using('file')->from('cxt:out')
  ;

$registry->route('self-update', 'Update the application if there is a newer version available.')
  ->does('\Fortissimo\CLI\Update\GetVersionFromTextFile', 'version1')
    ->using('file', FORT_APP_PATH .'/VERSION')
  ->does('\Fortissimo\CLI\Update\GetVersionFromTextFile', 'version2')
    ->using('file', 'https://raw.github.com/mattfarina/markdown-extra/master/VERSION')
  ->does('\Fortissimo\CLI\Update\CompareVersions', 'versionDiff')
    ->using('version1')->from('cxt:version1')
    ->using('version2')->from('cxt:version2')
  ->does('\Fortissimo\CLI\Update\Update')
    ->using('file', 'https://github.com/downloads/mattfarina/markdown-extra/markdown-extra')
    ->using('doUpdate')->from('cxt:versionDiff')
  ;

$registry->route('about', "Display information about the Markdown Extra CLI.")
  ->does('\Fortissimo\CLI\Update\GetVersionFromTextFile', 'version')
    ->using('file', FORT_APP_PATH .'/VERSION')
  ->does('\mattfarina\MarkdownExtra\About', 'helpText')
    ->using('version')->from('cxt:version')
  ->does('\Fortissimo\CLI\IO\Write')
    ->using('text')->from('cxt:helpText')
  ;
