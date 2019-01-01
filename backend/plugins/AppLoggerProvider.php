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
use Phalcon\Di;
use Phalcon\Di\Injectable;
use Phalcon\DiInterface;
use Phalcon\Logger\AdapterInterface as LoggerAdapterInterface;
use Phalcon\Logger\Factory as LoggerFactory;


/**
 * Class AppLoggerProvider
 * @package Here\Plugins
 * @property Config $config
 */
final class AppLoggerProvider extends Injectable {

    /**
     * @var LoggerAdapterInterface[]
     */
    private static $cached_loggers = array();

    /**
     * AppLoggerProvider constructor.
     * @param null|DiInterface $di
     */
    final public function __construct(?DiInterface $di = null) {
        $this->setDI($di ?? Di::getDefault());
    }

    /**
     * @return LoggerAdapterInterface
     */
    final public function getDefaultLogger(): LoggerAdapterInterface {
        return $this->getLogger($this->config->logging->default_logger);
    }

    /**
     * @return LoggerAdapterInterface
     */
    final public function getErrorLogger(): LoggerAdapterInterface {
        return $this->getLogger('error');
    }

    /**
     * @param string $name
     * @return LoggerAdapterInterface
     */
    final public function getLogger(string $name): LoggerAdapterInterface {
        /** @noinspection PhpUndefinedFieldInspection */
        $loggers_config = $this->config->logging->loggers->toArray();
        if (!isset($loggers_config[$name])) {
            /** @noinspection PhpUndefinedFieldInspection */
            $name = $this->config->logging->default_logger;
        }
        return self::getSpecifyLogger($loggers_config[$name]);
    }

    /**
     * @param array $logger_config
     * @return LoggerAdapterInterface
     */
    final private function getSpecifyLogger(array $logger_config): LoggerAdapterInterface {
        return self::createLogger($this->getUsableLoggingRoot(), $logger_config);
    }

    /**
     * @return string
     */
    final private function getUsableLoggingRoot(): string {
        /** @noinspection PhpUndefinedFieldInspection */
        $logging_root = $this->config->logging->logging_root;
        if (!self::isWritableRoot($logging_root)) {
            /** @noinspection PhpUndefinedFieldInspection */
            $logging_root = $this->config->logging->spare_logging_root;
        }
        return rtrim($logging_root, '/\\');
    }

    /**
     * @param string $root
     * @return bool
     */
    final private static function isWritableRoot(string $root): bool {
        if (!is_dir($root)) {
            if (self::isWritableRoot(dirname($root))) {
                mkdir($root, 0777, true);
                return true;
            }
            return false;
        }
        return is_writeable($root);
    }

    /**
     * @param string $root
     * @param array $logger
     * @return LoggerAdapterInterface
     */
    final private static function createLogger(string $root, array $logger): LoggerAdapterInterface {
        $path_segments = array($root, ltrim($logger['name'], '/\\'));

        // logger file name
        $logger_path = join(DIRECTORY_SEPARATOR, $path_segments);
        // check directory exists and created when not exists
        if (!is_dir(dirname($logger_path))) {
            mkdir(dirname($logger_path), 0777, true);
        }

        // logger cached
        if (!isset(self::$cached_loggers[$logger_path])) {
            self::$cached_loggers[$logger_path] = LoggerFactory::load(array(
                'adapter' => $logger['adapter'],
                'name' => $logger_path
            ));
        }
        return self::$cached_loggers[$logger_path];
    }

}
