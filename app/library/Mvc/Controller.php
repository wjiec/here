<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Library\Mvc;

use Bops\Mvc\Controller as BopsController;
use Here\Library\Field\Store\StoreInterface;
use Here\Model\Author;
use Phalcon\Tag;
use Phalcon\Text;
use Phalcon\Translate\Adapter as Translator;


/**
 * Class Controller
 *
 * @package Here\Library\Mvc
 *
 * @property Translator $translator
 * @property StoreInterface $field
 * @property Author $blogger
 */
class Controller extends BopsController {

    /**
     * Add CSP header
     */
    public function initialize() {
        $this->translator = container('translator', $this->request->getBestLanguage());
        /** @noinspection PhpUndefinedFieldInspection */
        $this->response->setHeader('Content-Security-Policy', $this->config->security->cap);
        /** @noinspection PhpUndefinedFieldInspection */
        $this->response->setHeader('X-Frame-Options', $this->config->security->frameOptions);
        /** @noinspection PhpUndefinedFieldInspection */
        $this->response->setHeader('X-XSS-Protection', $this->config->security->xssProtection);
        $this->response->setHeader('X-DNS-Prefetch-Control', 'on');

        $this->matchedViewTitle();
    }

    /**
     * Sets the title for action by default `title_{module}_{controller}_{action}`
     * on the i18n
     */
    private function matchedViewTitle() {
        $key = join('_', [
            /* prefix */'title',
            Text::uncamelize($this->dispatcher->getModuleName()),
            Text::uncamelize($this->dispatcher->getControllerName()),
            Text::uncamelize($this->dispatcher->getActionName())
        ]);

        if ($this->translator->exists($key)) {
            Tag::setTitle($this->translator->_($key));
        } else {
            Tag::setTitle($this->translator->_('title_unknown'));
        }
    }

    /**
     * Set page title from translated
     *
     * @param string $name
     */
    protected function setTitleI18n(string $name) {
        Tag::setTitle($this->translator->_($name));
    }

}
