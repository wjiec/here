<?php
/**
 * @package Here.JSON
 * @author ShadowMan
 */
class JSON {
    /**
     * @param array $array
     * @return string
     */
    public static function fromArray(Array $array) {
        return json_encode($array);
    }
    /**
     * @param String $json
     * @return array
     */
    public static function toArray(String $json) {
        return json_decode($json, true);
    }
    /**
     * @param String $json
     * @return Object
     */
    public static function toObject(String $json) {
        return json_decode($json);
    }
}
?>