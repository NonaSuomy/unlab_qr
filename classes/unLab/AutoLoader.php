<?php
/**
 * AutoLoader Class
 *
 * Temporarily not a class
 */

function __autoload($class)
{
	$unLabFolder = dirname(__FILE__) . DIRECTORY_SEPARATOR ;
	$parts 		= explode("\\", $class);
	$filename 	= $unLabFolder  . end($parts) . ".php";
	if ( file_exists($filename) )
	{
		require_once( $filename );
	}
}
