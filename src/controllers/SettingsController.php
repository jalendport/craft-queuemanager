<?php

namespace jalendport\queuemanager\controllers;

use jalendport\queuemanager\QueueManager;

use Craft;
use craft\web\Controller;

class SettingsController extends Controller
{
    // Public Methods
    // =========================================================================

    public function actionSave()
    {
        $this->requirePostRequest();

        $plugin = QueueManager::getInstance();
        $settings = Craft::$app->getRequest()->post();

        if(!Craft::$app->getPlugins()->savePluginSettings($plugin, $settings)) {
            Craft::$app->getSession()->setError(Craft::t('queue-manager', 'Couldn’t save settings.'));

            return null;
        }

        Craft::$app->getSession()->setNotice(Craft::t('queue-manager', 'Settings saved.'));

        return $this->redirectToPostedUrl();
    }
}
