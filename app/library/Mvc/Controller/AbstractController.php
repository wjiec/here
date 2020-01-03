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
namespace Here\Library\Mvc\Controller;

use Exception;
use Here\Model\Viewer;
use Here\Provider\Field\Store\StoreInterface;
use Phalcon\Cache\BackendInterface;
use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Tag;
use Phalcon\Text;
use Phalcon\Translate\Adapter;


/**
 * Class AbstractController
 * @package Here\Library\Mvc\Controller
 * @property BackendInterface $cache
 * @property StoreInterface $field
 */
abstract class AbstractController extends Controller {

    /**
     * @var Adapter
     */
    protected $translator;

    /**
     * Setups the administrator for application when
     * administrator has not loaded
     *
     * @return ResponseInterface|void
     * @throws Exception
     */
    public function initialize() {
        $this->translator = container('translator');
        // Redirect to setup page when administrator not loaded
        if (!container('administrator')->exists()) {
            if ($this->dispatcher->getControllerName() !== 'setup') {
                return $this->response->redirect(['for' => 'setup-wizard']);
            }
        }
        // Match title for each action automatic
        $this->matchActionTitle($this->dispatcher);
        // Record viewer into database and statistics after
        $this->recordViewer();
    }

    /**
     * Record viewer into database
     *
     * @throws Exception
     */
    protected function recordViewer() {
        if (!$this->session->has('viewer')) {
            $viewer = Viewer::factory(md5(random_bytes(16)));
            $viewer->setViewerIp($this->request->getClientAddress(true));
            $viewer->setViewerUserAgent($this->request->getUserAgent());
            $viewer->save();

            $this->session->set('viewer', $viewer->getViewerKey());
        }
    }

    /**
     * Returns the number of the pagination
     *
     * @param int $default
     * @return int
     */
    protected function getPaginationNumber(int $default = 1): int {
        return abs($this->request->getQuery('page', 'int!', $default));
    }

    /**
     * Returns the offset matches the pagination number
     *
     * @param int $size
     * @return int
     */
    protected function getPaginationOffset(int $size): int {
        return (int)(($this->getPaginationNumber() - 1) * $size);
    }

    /**
     * Sets the title for action by default `title_{module}_{controller}_{action}`
     * on the i18n
     *
     * @param Dispatcher $dispatcher
     */
    private function matchActionTitle(Dispatcher $dispatcher) {
        $title_key = join('_', [
            /* prefix */'title',
            Text::uncamelize($dispatcher->getModuleName()),
            Text::uncamelize($dispatcher->getControllerName()),
            Text::uncamelize($dispatcher->getActionName())
        ]);

        if ($this->translator->exists($title_key)) {
            Tag::setTitle($this->translator->_($title_key));
        }
    }

}
