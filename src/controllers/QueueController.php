<?php

namespace lukeyouell\queuemanager\controllers;

use lukeyouell\queuemanager\QueueManager;

use Craft;
use craft\web\Controller;

class QueueController extends Controller
{
    // Public Methods
    // =========================================================================

    public function actionRetry()
    {
        $this->requirePostRequest();

        $id = Craft::$app->getRequest()->getRequiredBodyParam('id');
        Craft::$app->getQueue()->retry($id);

        Craft::$app->getSession()->setNotice(Craft::t('queue-manager', 'Retrying job.'));

        return $this->redirectToPostedUrl();
    }

    public function actionRelease()
    {
        $this->requirePostRequest();

        $id = Craft::$app->getRequest()->getRequiredBodyParam('id');
        Craft::$app->getQueue()->release($id);

        Craft::$app->getSession()->setNotice(Craft::t('queue-manager', 'Job cancelled.'));

        return $this->redirectToPostedUrl();
    }

    public function actionRetryAll()
    {
        $this->requirePostRequest();

        $jobs = QueueManager::$plugin->queue->getJobs();

        if ($jobs) {
            foreach($jobs as $job) {
                Craft::$app->getQueue()->retry($job['id']);
            }
        }

        Craft::$app->getSession()->setNotice(Craft::t('queue-manager', 'Retrying all jobs.'));

        return $this->redirectToPostedUrl();
    }

    public function actionReleaseAll()
    {
        $this->requirePostRequest();

        $jobs = QueueManager::$plugin->queue->getJobs();

        if ($jobs) {
            foreach($jobs as $job) {
                Craft::$app->getQueue()->release($job['id']);
            }
        }

        Craft::$app->getSession()->setNotice(Craft::t('queue-manager', 'All jobs cancelled.'));

        return $this->redirectToPostedUrl();
    }
}
