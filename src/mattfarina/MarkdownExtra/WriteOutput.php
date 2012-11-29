<?php
/**
 * A basic command to write cli output via Symfony\Component\Console\Output\ConsoleOutput
 */

namespace mattfarina\MarkdownExtra;

/**
 * This command prints a message to output.
 *
 * The output datasource is expected to conform to the interface
 * \Fortissimo\CLI\IO\Output.
 */
class WriteOutput extends \Fortissimo\Command\Base {

  public function expects() {
    return $this
      ->description('The block of test to display in the console.')
      ->usesParam('text', 'The text to display.')
      ->usesParam('file', 'An optional file to write the output to.')
      ;
  }

  public function doCommand() {
    $text = $this->param('text');
    $file = $this->param('file');

    if (!empty($file)) {
      file_put_contents($file, $text);
    }
    else {
      $output = $this->context->datasource('output');

      $output->write($text);
    }
  }
}