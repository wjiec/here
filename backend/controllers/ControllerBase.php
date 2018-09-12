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
use Here\Libraries\Signature\Context;
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
     * @var Context
     */
    private $signer_context;

    /**
     * initializing controller first
     */
    final public function initialize() {
        // configure object
        $this->config = $this->di->get('config');
        // redis cache backend
        $this->cache = $this->di->get('cache');
        // logging service
        $this->logger = $this->di->get('logging');
        // translator plugin
        $this->translator = new Translator($this->config->application->languages_dir);
        // validate sign
        if (!$this->checkSignature()) {
            $this->makeResponse(self::STATUS_FATAL_ERROR, $this->translator->SYS_SIGNATURE_INVALID);
            $this->terminal();
        }
    }

    /**
     * @param int $status
     * @param null|string $message
     * @param array|null $data
     * @param array|null $extra
     * @return ResponseInterface
     */
    final protected function makeResponse(int $status, ?string $message = null,
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
            ->setHeader('X-Backend-Token', 'h-xx-xx-xxxxxxxx-xxxx')
            ->setJsonContent($response);
    }

    /**
     * terminal correct
     */
    final protected function terminal(): void {
        $this->response->send();
        exit(0);
    }

    /**
     * @return bool
     */
    final private function checkSignature(): bool {
        $this->signer_context = new Context();
        return true;
    }

    protected const STATUS_SUCCESS = 0;

    protected const STATUS_FAILURE = 1;

    protected const STATUS_FATAL_ERROR = -1;

}
