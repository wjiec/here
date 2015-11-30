<?php
/**
 * Thank for you reading this blog application.
 * 
 * @package Here
 * @author  ShadowMan
 */

var_dump($_SERVER);
# TODO Route
die(); # Route Debug

if (!defined('__HERE_ROOT_DIRECTORY__') && !@include_once 'config.php') {
    file_exists('./install.php') ? header('Location: install.php') : print('Missing Config File');
    exit;
}
