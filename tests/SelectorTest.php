<?php

namespace Chopin\EasyXML\Tests;

require dirname(__DIR__) . '../vendor/autoload.php';

use Chopin\EasyXML\Selector;

/**
 * SelectorTest
 *
 * @author  Xavier Chopin <bonjour@xavierchop.in>
 * @package Chopin\EasyXML
 * @license MIT
 */

$selector = new Selector('file2.xml');

$selector->all('fr');
/** Success (12)
 * echo $selector->countElement('book');
 *
 * Failure :
 * echo $selector->countElement(2);
 */
