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
     * @param string $file
     */
    public function __construct($file)
    {
        $this->load($file);
    }

    /**
     * Load a XML File
     *
     * @param string $file
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
     * @param string $message
     */
    public static function prettyError($message)
    {
        print_r('<h3> <strong><u>EasyXML Error:</u></strong> ' . $message . '</h3>');
    }

    /**
     * Count the nodes of the file loaded or the node given
     *
     * @param string $element
     * @return int $count
     */
    public function countElement($element = null)
    {
        if ($element != null) {
            if (is_string($element))
                return count($this->data->$element);
            else
                return self::prettyError('Element given is not a String!');
        }else {
            $count = 0;
            foreach ($this->data as $element) {
                $count++;
                $count+= $element->count();
            }
            return $count;
        }
    }

    /**
     * Return the first element given (object)
     *
     * @param string $element
     */
    public function first($element)
    {
        if (is_string($element))
            return $this->data->$element->__toString();
        else
            return self::prettyError('Element given is not a String!');
    }

    /**
     * Return the elements given (object)
     *
     * @param string $element
     */
    public function get($element)
    {
        if (!is_string($element))
            return self::prettyError('Element given is not a String!');

        $res = array();
        foreach ($this->data->$element as $child)
            array_push($res, $child->__toString());
        return $res;
    }

    /**
     * Check if a node has childrens
     *
     * @param \SimpleXMLElement $node
     */
    private function hasChildren($node)
    {
        if (sizeof($node) > 0)
            return true;
        else
            return false;
    }


    public function all($element)
    {
        $res = array();
        if (!is_string($element))
            return self::prettyError('Element given is not a String!');

        // ToDo: Appels récursifs
        foreach($this->data as $key => $val) {
            foreach($val as $key2 => $subval) {
                if ($key2 === $element){
                    var_dump($subval);
                }
            }

        }

    }
}
