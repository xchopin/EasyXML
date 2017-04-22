<?php

namespace Chopin\EasyXML;

/**
 * Selector
 *
 * @author  Xavier Chopin <bonjour@xavierchop.in>
 * @package Chopin\EasyXML
 * @license MIT
 */
class Selector
{
    protected $file;

    protected $data;

    /**
     * Create a new Selector
     * @param String $file
     */
    public function __construct($file)
    {
        $this->file = $file;
        $this->data = simplexml_load_file($file);

        if (!$this->data)
            print_r('<h3> <strong><u>EasyXML Error:</u></strong> XML file was not found! </h3>');
    }

    /**
     * Count the node of the file loaded
     * @param String $element
     */
    public function countElement($element) {
        $dom = new DOMDocument;
        $dom->loadXml($this->data);
        return $dom->getElementsByTagName($element)->length;
    }

}