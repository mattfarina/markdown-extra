<?php

/**
 * Generate the about text for the application.
 */

namespace mattfarina\MarkdownExtra;

/**
 * Generates the about text.
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

    return '<info>Markdown Extra CLI Version: ' . $version . ".</info>
The markdown-extra CLI is available under the MIT license
while the markdown library is available under a New BSD license.

For more details see http://github.com/mattfarina/markdown-extra.";
  }
}