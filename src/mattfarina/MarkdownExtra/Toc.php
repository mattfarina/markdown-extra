<?php

/**
 * Generate a TOC if tag {:toc} present.
 */

namespace mattfarina\MarkdownExtra;

/**
 * Generates the about text.
 */
class Toc extends \Fortissimo\Command\Base {

  public function expects() {
    return $this
      ->description('Converts {:toc} tags in an html document into tables of contents.')
      ->usesParam('html', 'The html to parse and update.')
      ->usesParam('enable', 'Whether or not to make the changes.')
      ->usesParam('ordered', 'Unordered lists are used to create the documention by default. If TRUE then ordered lists will be used instead.')
      ->andReturns('Updated html document with a table of contents.')
      ;
  }

  public function doCommand() {

    $html = $this->param('html', '');
    $enable = $this->param('enable', FALSE);

    $type = 'ul';
    if ($this->param('ordered')) {
      $type = 'ol';
    }

    $document = \QueryPath::withHTML($this->prepareHtml($html));

    if ($enable) {

      // The toc being generated.
      $toc = '';
      $curr = $last = 0;

      // Build the TOC
      $cmd = $this;
      $document->xpath('//h1|//h2|//h3|//h4|//h5|//h6')->each(function($index, $item) use (&$toc, $cmd, &$curr, &$last, $type) {

        // Put the header level into $curr (e.g., 1, 2, 3...)
        sscanf($item->tagName, 'h%u', $curr);

        // If the current level is greater than the last level indent one level
        if ($curr > $last) {
          $toc .= '<' . $type . ">\n";
        }
        // If the current level is less than the last level go up appropriate amount.
        elseif ($curr < $last) {
          $toc .= str_repeat('</li></' . $type .">\n", $last - $curr) . "</li>\n";
        }
        // If the current level is equal to the last.
        else {
          $toc .= "</li>\n";
        }

        $qpitem = \QueryPath::with($item);

        // Get and/or set an id
        if ($item->hasAttribute('id')) {
          $id = $item->getAttribute('id');
        }
        else {
          $id = $cmd->safeId($qpitem->text());
          $item->setAttribute('id', $id);
        }

        $toc .= '<li><a href="#' . $id . '">' . $qpitem->innerHTML() . "</a>\n";

        $last = $curr;

      });

      $toc .= str_repeat('</li></' . $type . '>', $last);

      $html = str_replace('{:toc}', $toc, $document->top('body')->innerHTML());
    }

    return $html;
  }

  /**
   * Create a HTML stuf document from a block of markup text.
   * 
   * @param  string $text
   *   A block of html text that would normally reside inside the body of a
   *   document.
   * @return string
   *   The text wrapped in an html document that makes it easier for the parser
   *   to work with.
   */
  protected function prepareHtml($text) {
    return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>' . $text . '</body></html>';
  }

  /**
   * Generate a safe html id to insert into markup.
   *
   * Not all characters are allowed in markup. This takes some text and converts
   * it into a safe and usable html id.
   *
   * @param  string $text
   *   The string of text to convert into a html id.
   *
   * @return string
   *   A valid html id.
   */
  public function safeId($text) {

    // Lowercase the string and convert a few characters.
    $id = strtr(strtolower($text), array(' ' => '-', '_' => '-', '[' => '-', ']' => ''));

    // Remove invalid id characters.
    $id = preg_replace('/[^A-Za-z0-9\-_]/', '', $id);

    return $id;
  }
}