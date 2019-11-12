<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/lsalio/here
 */
namespace Here\Provider\Logger;

use Here\Provider\AbstractServiceProvider;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Logger\Formatter\Line as LineFormatter;


/**
 * Class ServiceProvider
 * @package Here\Provider\Logger
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @var string
     */
    protected $service_name = 'logger';

    /**
     * @inheritDoc
     */
    final public function register() {
        $this->di->set($this->service_name, function(?string $filename = null) {
            $config = container('config')->logger;
            switch (strtolower($config->level)) {
                case 'emergency': $level = Logger::EMERGENCY; break;
                case 'critical': $level = Logger::CRITICAL; break;
                case 'alert': $level = Logger::ALERT; break;
                case 'error': $level = Logger::ERROR; break;
                case 'warning': $level = Logger::WARNING; break;
                case 'notice': $level = Logger::NOTICE; break;
                case 'info': $level = Logger::INFO; break;
                case 'debug': $level = Logger::DEBUG; break;
                default: $level = Logger::DEBUG;
            }

            $filename = trim(($filename ?: $config->filename), '\\/');
            if (strpos($filename, '.log') !== -1) {
                $filename = rtrim($filename, '.') . '.log';
            }

            $logger = new FileLogger(rtrim($config->root, '\\/') . DIRECTORY_SEPARATOR . $filename);
            $logger->setFormatter(new LineFormatter($config->format, $config->date));
            $logger->setLogLevel($level);

            return $logger;
        });
    }

}
