<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * MySQL database result.   See [Results](/database/results) for usage and examples.
 *
 * @package    Kohana/Database
 * @category   Query/Result
 * @author     Kohana Team
 * @copyright  (c) 2008-2009 Kohana Team
 * @license    http://kohanaphp.com/license
 */
class Kohana_HHVM_Database_MySQL_Result extends Kohana_Database_MySQL_Result {

	/**
	 * @var ReflectionClass
	 */
	protected $_reflect_class = NULL;

	/**
	 * Current item iterator
	 *
	 * @return array | class
	 */
	public function current()
	{
		if ($this->_current_row !== $this->_internal_row AND ! $this->seek($this->_current_row))
			return NULL;

		// Increment internal row for optimization assuming rows are fetched in order
		$this->_internal_row++;

		// Get row as associated array
		$row = mysql_fetch_assoc($this->_result);

		if ($this->_as_object === TRUE OR is_string($this->_as_object))
		{
			if ($this->_reflect_class === NULL)
			{
				// Create reflection class of given classname or stdClass
				$this->_reflect_class = new ReflectionClass(is_string($this->_as_object) ? $this->_as_object : 'stdClass');
			}

			// Get new instance without constructing it
			$object = $this->_reflect_class->newInstanceWithoutConstructor();

			foreach ($row as $column => $value)
			{
				// Trigger the class setter
				$object->__set($column, $value);
			}

			// Construct the class with no parameters
			$object->__construct(NULL);

			return $object;
		}

		return $row;
	}

} // End HHVM_Database_MySQL_Result