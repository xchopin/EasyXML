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
     *
     * @param String $file
     */
    public function __construct($file)
    {
        $this->load($file);
    }

    /**
     * Load a XML File
     *
     * @param String $file
     */
    public function load($file)
    {
        $this->file = $file;
        $this->data = simplexml_load_file($file);
        if (!$this->data)
            self::prettyError('XML file was not found!');
    }

    /**
     * Prints a 'pretty' error
     *
     * @param String $message
     */
    public static function prettyError($message)
    {
        print_r('<h3> <strong><u>EasyXML Error:</u></strong> ' . $message . '</h3>');
    }

    /**
     * Count the node of the file loaded
     *
     * @param String $element
     */
    public function countElement($element)
    {
        if (is_string($element))
            return count($this->data->$element);
        else
            return self::prettyError('Element given is not a String!');
    }



}