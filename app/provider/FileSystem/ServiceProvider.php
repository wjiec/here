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
namespace Here\Provider\FileSystem;

use Here\Provider\AbstractServiceProvider;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;


/**
 * Class ServiceProvider
 * @package Here\Provider\FileSystem
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @var string
     */
    protected $service_name = 'filesystem';

    /**
     * @inheritDoc
     */
    final public function register() {
        $this->di->set($this->service_name, function(?string $root = null) {
            if (!$root) {
                $root = dirname(app_path());
            }
            return new Filesystem(new Local($root));
        });
    }

}
