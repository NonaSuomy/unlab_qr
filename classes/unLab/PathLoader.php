<?php
/**
 * This is helper class to get paths or URLs
 */
namespace Unlab;

class PathLoader
{
	/**
	 * Return the Base URL of this project
	 * @return string http://....
	 */
	public static function getRootURL()
	{
		return 'http://' . $_SERVER['SERVER_NAME'];
	}
}