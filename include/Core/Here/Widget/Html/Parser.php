<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Html_Parser extends Abstract_Widget {
    public function start() {
        $this->_config->_rootPath = 'include/Theme';
        $this->_config->_themeName = Manager_Widget::widget('helper')->options()->theme;
        $this->_config->_defaultTheme = 'default';
        $this->_config->_templateDir = 'templates';
    }

    public function a($href, $text, $blank = true, $title = null) {
        return "<a href=\"{$href}\" title=\"{$title}\"" . ($blank ? " target=\"_blank\"" : null) . ">{$text}</a>";
    }

    public function article($data, array $mapping = array(), $template = 'article.tpl') {
        if (is_callable($data)) {
            $data = $data();
        }

        $data = self::array_keys_replace(array_keys($mapping), array_values($mapping), $data);

        if ($template = $this->fileFinder($template)) {
            $contents = Manager_Widget::widget('template')->template($template, $data);
        } else {
            throw new Exception('Template File <' . $template . '> Not Found.');
        }
    }

    private function fileFinder($filename) {
        if (is_file(join('/', array($this->_config->_rootPath, $this->_config->_themeName, $this->_config->_templateDir, $filename)))) {
            return join('/', array($this->_config->_rootPath, $this->_config->_themeName, $this->_config->_templateDir, $filename));
        } else if (is_file(join('/', array($this->_config->_rootPath, $this->_config->_defaultTheme, $this->_config->_templateDir, $filename)))) {
            return join('/', array($this->_config->_rootPath, $this->_config->_defaultTheme, $this->_config->_templateDir, $filename));
        } else {
            return null;
        }
    }

    private static function array_keys_replace($search, $replacement, $subject) {
        $combine = array_combine($search, $replacement);
        $temp = array();

        if (!is_array($subject)) {
            return $temp;
        }

        foreach ($subject as $key => &$val) {
            if (is_array($val)) {
                $val = self::array_keys_replace($search, $replacement, $val);
            }

            if (array_key_exists($key, $combine)) {
                $temp[$combine[$key]] = $val;
            } else {
                $temp[$key] = $val;
            }
        }

        return $temp;
    }
}

?>