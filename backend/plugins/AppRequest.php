<?php
/**
 * AppRequest
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Plugins;


use Here\Libraries\RSA\RSAError;
use Here\Libraries\RSA\RSAObject;
use Phalcon\Http\Request;


/**
 * Class AppRequest
 * @package Here\Plugins
 */
final class AppRequest extends Request {

    /**
     * @var RSAObject
     */
    private $rsa_object;

    /**
     * @var string[]
     */
    private $encrypt_cache;

    /**
     * @param RSAObject $rsa_object
     * @return AppRequest
     */
    final public function setRsaObject(RSAObject $rsa_object): self {
        $this->rsa_object = $rsa_object;
        return $this;
    }

    /**
     * @param string|null $name
     * @param string $filters
     * @param null $defaultValue
     * @return mixed
     */
    final public function getEncrypted(string $name = null, string $filters = null, $defaultValue = null) {
        if (!$this->encrypt_cache) {
            $this->encrypt_cache = array();
            if ($this->rsa_object) {
                try {
                    // decrypt content from request
                    $raw_json = $this->rsa_object->decrypt($this->getRawBody());
                    // decode from json to cache
                    $this->encrypt_cache = json_decode($raw_json, true);
                    // check json correct
                    $this->encrypt_cache = $this->encrypt_cache ?? array();
                } catch (RSAError $e) {
                    // do nothing when an exception occurs, just the empty result
                }
            }
        }
        return $this->getHelper($this->encrypt_cache, $name, $filters, $defaultValue);
    }

}
