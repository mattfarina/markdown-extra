<?php

/**
 * Get text from StdIn. When Ctrl+D is input to end StdIn the chain continues.
 */

namespace mattfarina\MarkdownExtra;

/**
 * Gets text from StdIn.
 */
class GetFromStdIn extends \Fortissimo\Command\Base {

  public function expects() {
    return $this
      ->description('Gets test from StdIn.')
      ->andReturns('The text recorded in StdIn.')
      ;
  }

  public function doCommand() {

    $handle = fopen('php://stdin', 'r');
    $buffer = '';

    while(!feof($handle)) {
      $buffer .= fgets($handle);
    }

    return $buffer;

  }
}