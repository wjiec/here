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
namespace Here\Provider\Config;

use League\Flysystem\Filesystem;
use Phalcon\Config;


/**
 * Class Factory
 * @package Here\Libraries\Config
 */
final class Factory {

    /**
     * Create configure object
     *
     * @param array $configs
     * @return Config
     */
    final public static function create(array $configs = array()): Config {
        $config = new Config();

        /* @var $filesystem Filesystem */
        $filesystem = container('filesystem', cache_path('config'));
        if ($filesystem->has('cached.php') && !environment('development')) {
            return static::merge($config, cache_path('config/cached.php'));
        }

        foreach ($configs as $cfg) {
            static::merge($config, config_path("{$cfg}.php"), ($cfg === 'config' ? null : $cfg));
        }

        static::dump($filesystem, 'cached.php', $config->toArray());
        return $config;
    }

    /**
     * Merge other configure to main object
     *
     * @param Config $config
     * @param string $path
     * @param string|null $mount
     * @return Config
     */
    final private static function merge(Config $config, string $path, ?string $mount = null): Config {
        /** @noinspection PhpIncludeInspection */
        $value = include $path;
        if (is_array($value)) {
            $value = new Config($value);
        }

        if ($value instanceof Config) {
            if (!$mount) {
                return $config->merge($value);
            }
            $config[$mount] = (new Config())->merge($value);
        }
        return $config;
    }

    /**
     * Dump the configure to cache file
     *
     * @param Filesystem $filesystem
     * @param string $file
     * @param array $data
     */
    final private static function dump(Filesystem $filesystem, string $file, array $data): void {
        $contents = '<?php' . PHP_EOL
            . '/* !! PLEASE DO NOT EDIT THIS FILE DIRECTLY !! */' . PHP_EOL
            . 'return ' . var_export($data, true) . ';' . PHP_EOL;
        $filesystem->put($file, $contents, $data);
    }

}
