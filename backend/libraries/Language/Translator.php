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


use Phalcon\Di;
use Phalcon\Translate\Adapter\NativeArray as NativeArrayTranslator;


/**
 * Class Translator
 * @package Here\Libraries\Language
 */
final class Translator extends NativeArrayTranslator {

    /**
     * @var string
     */
    private $lang_name;

    /**
     * Translator constructor.
     * @param string $lang_root
     * @param null|string $lang
     */
    final public function __construct(string $lang_root, ?string $lang = null) {
        if ($lang !== null) {
            $contents = $this->getLangContents($lang_root, $lang);
            if ($contents) {
                parent::__construct(array('content' => $contents));
            }
        } else {
            $lang = strtolower(Di::getDefault()->get('request')->getBestLanguage());
            if (!empty($lang)) {
                $contents = self::getLangContents($lang_root, substr($lang, 0, 2));
                if ($contents) {
                    parent::__construct(array('content' => $contents));
                }
            } else {
                parent::__construct(array('content' => $this->getLangContents($lang_root, 'en')));
            }
        }
    }

    /**
     * @return string
     */
    final public function getLang(): string {
        return $this->lang_name;
    }

    /**
     * @param string $lang_root
     * @param string $lang
     * @return array|null
     */
    final private function getLangContents(string $lang_root, string $lang): ?array {
        $lang_file = rtrim($lang_root) . '/' . $lang . '.php';
        if (is_file($lang_file) && is_readable($lang_file)) {
            /** @noinspection PhpIncludeInspection */
            $contents = include $lang_file;
            if (is_array($contents)) {
                $this->lang_name = $lang;
                return $contents;
            }
        }
        return null;
    }

}
