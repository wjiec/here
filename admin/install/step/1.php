<?php
if (!function_exists('_u')) {
    function _u($path) {
        echo Request::getFullUrl($path);
    }
}
?>
<h3>Welcome to Here.</h3>
<p>Here is distributed under the <a href="<?php _u('license.php'); ?>" target="_blank">MIT</a> license.</p>
<p>This Installer will automatically detect server environment is in line with the minimum configuration requirements. If not meet,  please follow the instructions in your host configuration information to check if the server environment to meet the requirements</p>