<?php

/**
 * Generate the about text for the application.
 */

namespace mattfarina\MarkdownExtra;

/**
 * This command prints a message to output.
 *
 * The output datasource is expected to conform to the interface
 * \Fortissimo\CLI\IO\Output.
 */
class About extends \Fortissimo\Command\Base {

  public function expects() {
    return $this
      ->description('The about text.')
      ->usesParam('version', 'The version of the application to display.')
      ->andReturns('The help text block.')
      ;
  }

  public function doCommand() {

    $version = $this->param('version', '');

    return 'Markdown Extra CLI Version: ' . $version . ".\n";
  }
}