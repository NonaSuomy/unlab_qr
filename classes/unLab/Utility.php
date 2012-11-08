<?php
/**
 * This is just a little helper class
 * with some static methods for general usage
 * @date  	8th Nov 2012
 * @version 1.0
 */

namespace Unlab;

class Utility
{
	/**
	 * Returns a value from the $_POST,
	 * if that cannot be found or is not set,
	 * it will return a default
	 * @param $string val
	 * @param $multi default
	 */
	public static function getPostVal($val, $default = "")
	{
		if (isset($_POST[$val]) && !empty($_POST[$val]))
		{
			return $_POST[$val];
		}
		else
		{
			return $default;
		}
	}

	/**
	 * Returns a value from the $_GET,
	 * if that cannot be found or is not set,
	 * it will return a default
	 * @param $string val
	 * @param $multi default
	 */
	public static function getGetVal($val, $default = "")
	{
		if (isset($_GET[$val]) && !empty($_GET[$val]))
		{
			return $_GET[$val];
		}
		else
		{
			return $default;
		}
	}
}