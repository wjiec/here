<?php
/**
 * AppLoggerProvider.php
 * @noinspection PhpUndefinedFieldInspection
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Plugins;


use Phalcon\Config;
use Phalcon\Di\Injectable;
use Phalcon\Logger\AdapterInterface as LoggerAdapterInterface;
use Phalcon\Logger\Factory as LoggerFactory;


/**
 * Class AppLoggerProvider
 * @package Here\Plugins
 * @property Config $config
 */
final class AppLoggerProvider extends Injectable {

    /**
     * @param string $name
     * @return LoggerAdapterInterface
     */
    final public function getLogger(string $name): LoggerAdapterInterface {
        // logging configure
        $logging_config = $this->config->get('logging')->toArray();
        if (!isset($logging_config[$name])) {
            $name = $logging_config['default_logger_name'];
        }
        // logger definition
        $logger = $logging_config['loggers'][$name];
        $logger_path = join(DIRECTORY_SEPARATOR, array(
            $this->getUsableLoggingRoot(), $logger['name'])
        );
        // check directory exists and created when not exists
        if (!is_dir(dirname($logger_path))) {
            mkdir(dirname($logger_path), 0777, true);
        }
        // generate adapter
        return LoggerFactory::load(array(
            'adapter' => $logger['adapter'],
            'name' => $logger_path
        ));
    }

    /**
     * @return string
     */
    final private function getUsableLoggingRoot(): string {
        $default_root = $this->config->application->logging_root;
        if (is_writable($default_root)) {
            return rtrim($default_root, '/\\');
        }
        return rtrim($this->config->logging->spare_logging_root, '/\\');
    }

}
