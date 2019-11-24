<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/nosjay/here
 */
namespace Here\Provider\Translator;

use Here\Provider\AbstractServiceProvider;
use Phalcon\Translate\Adapter\NativeArray;


/**
 * Class ServiceProvider
 * @package Here\Provider\Translator
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @var string
     */
    protected $service_name = 'translator';

    /**
     * @inheritDoc
     */
    final public function register() {
        $this->di->set($this->service_name, function(string $language = '', ...$args) {
            $translator = Factory::factory($language);
            if (empty($args)) {
                return $translator;
            }
            return $translator->query(...$args);
        });
    }

}
