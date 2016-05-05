<?php
/**
 * Live Composer registry class
 */

/**
 * LC_Registry Class
 */
class LC_Registry {

	/**
	 * Saved variables
	 * @var associative array
	 */
    protected $_objects = array();

    /**
     * Set object
     * @param string $name
     * @param mixed $object
     */
    function set($name, $object)
    {
        $this->_objects[$name] = $object;
    }

    /**
     * Returns saved obj
     * @param  string $name
     * @return mixed
     */
    function get($name)
    {
        return isset($this->_objects[$name]) ? $this->_objects[$name] : null;
    }

}

/// Registry object
$LC_Registry = new LC_Registry;