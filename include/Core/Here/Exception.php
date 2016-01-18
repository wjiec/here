<?php
/**
 * @author ShadowMan
 * @package Core.Exception
 */
// TODO: error handle
class Here_Exception extends Exception{
    public function __construct($message, $code, $previous) {
        $this->message = $message;
        $this->code    = $code;

        Core::router()->error('404');
    }

    public function getMessage() {
    }

    public function getCode() {
    }

    public function getFile() {
    }

    public function getLine() {
    }

    public function getTrace() {
    }

    public function getPrevious() {
    }

    public function getTraceAsString () {
    }

    function __toString () {
    }

    public static function router(&$r) {
        self::$_router = $r;
    }

    public static function tigger($message, $code, $previous) {
//         self::$_router->error('404', $message);
    }
    /**
     * htmlEntities 
     * @param string $html
     * @return string
     */
    private static function htmlEntities($html) {
        return htmlentities($html);
    }
}
?>