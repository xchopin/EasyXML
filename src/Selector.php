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
     * Return the first node given
     *
     * @param string $element
     */
    public function first($element, $parent = null)
    {
        if (!is_string($element))
            return self::prettyError('Element given is not a String!');

        if ($parent == null)
            return $this->data->$element;

    }

    /**
     * Return the elements given (object)
     *
     * @param string $element
     */
    public function get($element)
    {
        if (!is_string($element))
            return self::prettyError('Element given is not a string!');

        $res = array();
        foreach($this->data as $child) {
           array_push($res,$this->dig($child,$element));
        }

        return $res;
    }



    /**
     * Check if a node has childrens
     *
     * @param \SimpleXMLElement $node
     */
    private function hasChildren($node)
    {
        if (!is_string($node) && sizeof($node) > 1)
            return true;
        else
            return false;
    }


    private function dig($node, $element)
    {
        if ($this->hasChildren($node)) {
            foreach($node as $key=>$child) {
                $this->dig($child,$element);
                if ($key === $element) {
                    return $child->__toString();
                }
            }
        }
    }


    /**
     * Transform a XML to an array
     *
     * @param null $parent
     * @return array
     */
    public function toArray($parent = null)
    {
        if ($parent == null)
            $parent = $this->data;

        $array = array();
        foreach ($parent as $name => $element) {
            ($node = & $array[$name]) && (1 === count($node) ?
                $node = array($node) : 1) && $node = & $node[];
            $node = $element->count() ? $this->toArray($element) : trim($element);
        }

        return $array;
    }

    /**
     * Give the subnodes given, from the parent given
     *
     * @param $element
     * @param null $parent
     */
    public function nodes($element, $parent = null)
    {
        if (!is_string($element))
            return self::prettyError('Element given is not a string!');

        if ($parent === null)
            $parent = $this->data;

        $res = array();
        foreach ($parent as $key => $child) {
            if ($key == $element)
                array_push($res, $child);
        }

        return $res;
    }

    /**
     * Give the value of a node
     *
     * @param $node
     * @return mixed
     */
    public static function value($node)
    {
        if (sizeof($node) == 1) {
            if (is_array($node))
                $node = $node[0];

            return $node->__toString();
        }

        return false;
    }


    /**
     * Get the value of an element from a node
     *
     * @param $element
     * @param $node
     * @return mixed
     */
    public function valueFrom($element, $node)
    {
        return self::value($node->$element);
    }


}
