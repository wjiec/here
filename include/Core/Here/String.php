<?php
/**
 * @author ShadowMan
 * @package Core.String
 */
class String {
    public static function pawdEncrypt($pawd, $raw = false) {
        return strtoupper(md5((substr(sha1($pawd), 7, 15) . "F")));
    }
}
?>