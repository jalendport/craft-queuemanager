<?php

namespace lukeyouell\queuemanager\utilities;

use lukeyouell\queuemanager\QueueManager;
use lukeyouell\queuemanager\assetbundles\CpBundle;

use Craft;
use craft\base\Utility;

class Queue extends Utility
{
    // Static Methods
    // =========================================================================

    public static function displayName(): string
    {
        return Craft::t('queue-manager', 'Queue Manager');
    }

    public static function id(): string
    {
        return 'queue-manager';
    }

    public static function iconPath()
    {
        return Craft::getAlias("@lukeyouell/queuemanager/icon-mask.svg");
    }

    public static function contentHtml(): string
    {
        Craft::$app->view->registerAssetBundle(CpBundle::class);

        $variables = [
            'jobs' => QueueManager::$plugin->queue->getJobs(),
        ];

        return Craft::$app->getView()->renderTemplate(
            'queue-manager/_utility',
            $variables
        );
    }
}
