<?php
/**
 * Translator.php
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Libraries\Language;


use Phalcon\Config;
use Phalcon\Di;


/**
 * Class Translator
 * @package Here\Libraries\Language
 * @property string SYS_SIGNATURE_INVALID signature invalid error
 * @property string AUTHOR_REGISTER_INVALID
 * @property string AUTHOR_REGISTER_INCORRECT
 * @property string AUTHOR_REGISTER_WELCOME
 * @property string AUTHOR_REGISTER_FORBIDDEN
 */
final class Translator {

    /**
     * @var string
     */
    private $lang_name;

    /**
     * @var Config
     */
    private $lang_config;

    /**
     * Translator constructor.
     * @param null|string $lang_dir
     * @param string $force_lang
     */
    final public function __construct(string $lang_dir, ?string $force_lang = null) {
        if ($force_lang !== null) {
            $force_lang_file = rtrim($lang_dir) . '/' . $force_lang . '.php';
            if (is_file($force_lang_file) && is_readable($force_lang_file)) {
                $this->lang_name = $force_lang;
                /** @noinspection PhpIncludeInspection */
                $this->lang_config = include $force_lang_file;
            }
        }

        $best_lang = strtolower(Di::getDefault()->get('request')->getBestLanguage());
        if (!empty($best_lang)) {
            $best_lang = substr($best_lang, 0, 2);
        }

        $this->lang_name = $best_lang ? $best_lang : 'en';
        $lang_file = rtrim($lang_dir) . '/' . $this->lang_name . '.php';
        /** @noinspection PhpIncludeInspection */
        $this->lang_config = include $lang_file;
    }

    /**
     * @return string
     */
    final public function getLang(): string {
        return $this->lang_name;
    }

    /**
     * @param string $path
     * @return string
     */
    final public function __get(string $path): string {
        $segments = array_map('strtolower', explode('_', $path));

        $current_config = &$this->lang_config;
        foreach ($segments as $segment) {
            if (isset($current_config->{$segment})) {
                $current_config = &$current_config->{$segment};
            } else {
                break;
            }
        }

        if (!is_string($current_config)) {
            return '';
        }
        return $current_config;
    }

}
