<?php
/**
 *
 * @author ShadowMan
 */
class Widget_Common_Footer implements Widget_Abstract {
    function __construct() {
    }

    public static function start() {
        echo <<<EOF
</body>
</html>
EOF;
    }
}

?>