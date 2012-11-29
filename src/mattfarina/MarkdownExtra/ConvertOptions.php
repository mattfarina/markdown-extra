<?php

/**
 * Get text from StdIn. When Ctrl+D is input to end StdIn the chain continues.
 */

namespace mattfarina\MarkdownExtra;

use Symfony\Component\Console\Input\InputOption;

/**
 * Gets text from StdIn.
 */
class ConvertOptions extends \Fortissimo\Command\Base {

  public function expects() {
    return $this
      ->description('Adds the CLI options for conversions.')
      ->usesParam('inputDefinition', 'An object of Symfony\Component\Console\Input\InputDefinition.')
      ->andReturns('Nothing.')
      ;
  }

  public function doCommand() {

    $id = $this->param('inputDefinition');

    $id->addOption(new InputOption('file', 'f', InputOption::VALUE_OPTIONAL, 'Input file (optional). StdIn will be used if no file is provided.'));
    $id->addOption(new InputOption('out', 'o', InputOption::VALUE_OPTIONAL, 'Output file (optional). StdOut will be used if no file is provided.'));

  }
}