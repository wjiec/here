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


use Phalcon\Cache\Backend\Redis;
use Phalcon\Config;
use Phalcon\Dispatcher;
use Phalcon\Http\ResponseInterface;
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
     * @var Redis
     */
    protected $cache;

    /**
     * initializing controller first
     */
    final public function initialize() {
        // configure object
        $this->config = $this->di->get('config');
        // redis cache backend
        $this->cache = $this->di->get('cache');
    }

    /**
     * @param Dispatcher $dispatcher
     */
    final public function beforeExecuteRoute(Dispatcher $dispatcher) {
        // avoid circulate reference
//        if ($dispatcher->getHandlerClass() !== InstallerController::class) {
//            // check application installed
//            if (!$this->checkApplicationInstalled()) {
//                // forward to installing
//                $this->dispatcher->forward(array(
//                    'module' => 'frontend',
//                    'controller' => 'installer',
//                    'action' => 'first'
//                ));
//            }
//        }
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
        if ($status === self::STATUS_OK && $message === null) {
            $message = 'success';
        }

        $response = array_merge(array(
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ), $extra ?? array());

        return $this->response
            ->setHeader('X-Backend-Token', 'h-xx-xx-xxxxxxxx-xxxx')
            ->setJsonContent($response);
    }

    /**
     * @return bool
     */
    final private function checkApplicationInstalled(): bool {
        $config_root = $this->di->get('config')->application->configs_root;
        return is_file($config_root . '/application_installed');
    }

    protected const STATUS_OK = 0;

}
