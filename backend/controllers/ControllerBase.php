<?php
/**
 * ControllerBase.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Controllers;


use Here\Libraries\Language\Translator;
use Here\plugins\AppRedisBackend;
use Phalcon\Config;
use Phalcon\Http\ResponseInterface;
use Phalcon\Logger\Adapter;
use Phalcon\Mvc\Controller;


/**
 * Class ControllerBase
 * @package Here\Controllers
 */
abstract class ControllerBase extends Controller {

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var AppRedisBackend
     */
    protected $cache;

    /**
     * @var Adapter
     */
    protected $logger;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * initializing controller first
     */
    public function initialize() {
        // configure object
        $this->config = $this->di->get('config');
        // redis cache backend
        $this->cache = $this->di->get('cache');
        // logging service
        $this->logger = $this->di->get('logging');
        // translator plugin
        $this->translator = new Translator($this->config->application->languages_dir);
    }

    /**
     * @param int $status
     * @param null|string $message
     * @param array|null $data
     * @param array|null $extra
     * @return ResponseInterface
     */
    protected function makeResponse(int $status, ?string $message = null,
                                          ?array $data = null, ?array $extra = null): ResponseInterface {
        if ($status === self::STATUS_SUCCESS && $message === null) {
            $message = 'success';
        }

        $response = array_merge(array(
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ), $extra ?? array());

        return $this->response
            ->setHeader('Access-Control-Expose-Headers', 'X-Backend-Token')
            ->setJsonContent($response);
    }

    /**
     * terminal correct
     * @param int $status_code
     */
    final protected function terminal(int $status_code = 200): void {
        $this->response
            ->setStatusCode($status_code)
            ->send();
        exit(0);
    }

    protected const STATUS_SUCCESS = 0x0000;

    protected const STATUS_FAILURE = 0x0001;

    protected const STATUS_FATAL_ERROR = 0xffff;

}
