<?php

namespace lukeyouell\queuemanager\controllers;

use lukeyouell\queuemanager\QueueManager;
use lukeyouell\queuemanager\assetbundles\CpBundle;

use Craft;
use craft\web\Controller;

class CpController extends Controller
{
    // Public Properties
    // =========================================================================

    public $variables;

    // Public Methods
    // =========================================================================

    public function init()
    {
        parent::init();

        $this->variables = [
            'title' => 'Queue Manager',
        ];
    }

    public function actionJobs($status = null, array $variables = [])
    {
        $variables = array_merge($this->variables, $variables, [
            'jobs' => QueueManager::$plugin->queue->getJobs($status)
        ]);

        $this->view->registerAssetBundle(CpBundle::class);

        return $this->renderTemplate('queue-manager/_jobs/index', $variables);
    }

    // Private Methods
    // =========================================================================

    private function _getNavItems()
    {
        return [
            [
                'handle' => 'all',
                'label'  => 'All Jobs',
            ],
            [
                'heading' => 'Status',
            ],
            [
                'handle' => 'waiting',
                'status' => 'grey',
                'label'  => 'Waiting',
            ],
            [
                'handle' => 'reserved',
                'status' => 'orange',
                'label'  => 'Reserved',
            ],
            [
                'handle' => 'failed',
                'status' => 'red',
                'label'  => 'Failed',
            ],
        ];
    }

    private function _getSelectedItem()
    {
        return Craft::$app->getRequest()->getSegment(2) ?? 'all';
    }
}
