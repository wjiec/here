<?php
if (!function_exists('_u')) {
    function _u($path) {
        echo 'http://' . $_SERVER['HTTP_HOST'] . '/' . $path;
    }
}
?>
<h3>Welcome to Here.</h3>
<p href='/pjax.php/installer/step'>Here is distributed under the <a href="<?php _u('license.php'); ?>" target="_blank">MIT</a> license.</p>
<p>This Installer will automatically detect server environment is in line with the minimum configuration requirements. If not meet,  please follow the instructions in your host configuration information to check if the server environment to meet the requirements</p>