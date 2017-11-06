<?php

//Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null :
    define('SITE_ROOT', 'C:'.DS.'wamp64'.DS.'www'.DS.'Sites'.DS.'PhotoGallery');

defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');

// load config file first
require_once(LIB_PATH.DS.'config.php');

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS.'function.php');

// load core objects
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'database_object.php');
require_once(LIB_PATH.DS.'logger.php');
require_once(LIB_PATH.DS.'datetime.php');
require_once(LIB_PATH.DS.'pagination.php');
require_once(LIB_PATH.DS.'codding.php');
require_once(LIB_PATH.DS.'validate.php');
require_once(LIB_PATH.DS.'phpMailer'.DS.'PHPMailerAutoload.php');
require_once(LIB_PATH.DS.'phpMailer'.DS.'language'.DS.'phpmailer.lang-sr.php');

// load database-related classes
require_once(LIB_PATH.DS.'user.php');
require_once(LIB_PATH.DS.'subject.php');
require_once(LIB_PATH.DS.'photograph.php');
require_once(LIB_PATH.DS.'comment.php');

?>