<?php
/**
 * UrlValidator.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Io\Filter\Validator;
use Here\Lib\Io\Filter\IoFilterBase;


/**
 * Class UrlValidator
 * @package Here\Lib\Io\Filter\Validator
 */
final class UrlValidator extends IoFilterBase {
    final public function __construct(
        $require_scheme = true,
        $require_host = true,
        $require_path = false,
        $require_query = false
    ) {
        if ($require_scheme === true) {
            $this->add_flag(FILTER_FLAG_SCHEME_REQUIRED);
        }

        if ($require_host === true)  {
            $this->add_flag(FILTER_FLAG_HOST_REQUIRED);
        }

        if ($require_path === true)  {
            $this->add_flag(FILTER_FLAG_PATH_REQUIRED);
        }

        if ($require_query === true)  {
            $this->add_flag(FILTER_FLAG_QUERY_REQUIRED);
        }
    }

    /**
     * @see IoFilterBase::apply()
     * @param string $object
     * @param bool|mixed $default
     * @return mixed
     */
    final public function apply($object, $default = false) {
        $this->default = $default;
        return filter_var($object, FILTER_VALIDATE_URL, $this->get_options());
    }
}
