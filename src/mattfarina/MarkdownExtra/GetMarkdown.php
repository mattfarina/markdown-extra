<?php

/**
 * Get text from StdIn. When Ctrl+D is input to end StdIn the chain continues.
 */

namespace mattfarina\MarkdownExtra;

/**
 * Gets text from StdIn.
 */
class GetMarkdown extends \Fortissimo\Command\Base {

  public function expects() {
    return $this
      ->description('Gets test from StdIn.')
      ->usesParam('file', 'An optional file to get the input from.')
      ->andReturns('The text recorded in StdIn.')
      ;
  }

  public function doCommand() {

    $file = $this->param('file', '');

    $buffer = '';
    if (!empty($file) && file_exists($file)) {

      // @todo Handle case where file is not readable.
      $buffer = file_get_contents($file);

    }
    elseif (!empty($file)) {
      $output = $this->context->datasource('output');
      $output->writeln('<error>Unable to open file: ' . $file . '</error>');
      die();
    }
    else {
      $handle = fopen('php://stdin', 'r');

      while(!feof($handle)) {
        $buffer .= fgets($handle);
      }
    }

    return $buffer;

  }
}