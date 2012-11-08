<?php
/**
 * Just a general config file to set some CONSTANTS etc.
 */
require "./classes/phpqrcode/qrlib.php";
require "./classes/unLab/AutoLoader.php";

//switch error_reporting on
error_reporting(E_ALL);
ini_set('display_errors','On');

//Set CONSTANTS
define("BASEURL" , Unlab\PathLoader::getRootURL() );