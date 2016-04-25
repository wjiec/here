<?php
/**
 *
 * @author ShadowMan
 */
class Widget_Common_Header implements Widget_Abstract {
    public static function start() {
        $config = Theme::configGet();
?>
<?php
function _u($path) {
    echo Request::getFullUrl($path);
}
function _e($val) {
    echo $val;
}
function isMobile() {
    $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
    return (strpos($ua, 'iphone') || strpos($ua, 'ipad') || strpos($ua, 'android') || strpos($ua, 'midp') || strpos($ua, 'ucweb'));
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?php _e($config->title); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
    <!-- style library -->
    <link rel="stylesheet" href="<?php _u('/include/Resource/css/library/grid-alpha.css'); ?>" media="all" />
    <!-- Font -->
    <link rel="stylesheet" href="<?php _u('/include/Resource/css/library/fonts/fira.css'); ?>" media="all" />
    <link rel="stylesheet" href="<?php _u('/include/Resource/css/library/fonts/inconsolata.css'); ?>" media="all" />
<?php if (isMobile()): ?>
    <!-- mobile lirary -->
    <script src="<?php _u("/include/Resource/js/library/mobile/zepto.min.js"); ?>"></script>
    <script src="<?php _u("/include/Resource/js/library/mobile/fastclick.min.js"); ?>"></script>
<?php else: ?>
    <!-- PC library -->
    <script src="<?php _u("/include/Resource/js/library/jquery-2.1.4.min.js"); ?>"></script>
<?php endif; ?>
    <!-- module Resource -->
<?php
    Widget_Manage::style();
    Widget_Manage::javascript();
?>
</head>
<body>
<?php
    }
}

?>