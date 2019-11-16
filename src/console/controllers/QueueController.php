<?php

namespace jalendport\queuemanager\console\controllers;

use jalendport\queuemanager\QueueManager;

use Craft;

use yii\console\Controller;
use yii\helpers\Console;

class QueueController extends Controller
{
    // Public Methods
    // =========================================================================

    public function actionRetry($id = null)
    {
        if (!$id) {
            $this->outputString('Error', Console::BOLD, Console::FG_RED);
            $this->outputString('- You must supply a job id', Console::FG_RED);
        } else {
            $this->outputString('- Retrying job #'.$id, Console::FG_YELLOW);

            Craft::$app->getQueue()->retry($id);

            $this->outputString('Finished', Console::BOLD, Console::FG_GREEN);
        }
    }

    public function actionCancel($id = null)
    {
        if (!$id) {
            $this->outputString('Error', Console::BOLD, Console::FG_RED);
            $this->outputString('- You must supply a job id', Console::FG_RED);
        } else {
            $this->outputString('- Cancelling job #'.$id, Console::FG_YELLOW);

            Craft::$app->getQueue()->release($id);

            $this->outputString('Finished', Console::BOLD, Console::FG_GREEN);
        }
    }

    public function actionRetryAll()
    {
        $jobs = QueueManager::$plugin->queue->getJobIds();

        if (!$jobs) {
            $this->outputString('Error', Console::BOLD, Console::FG_RED);
            $this->outputString('- There are no jobs to retry', Console::FG_RED);
        } else {
            foreach($jobs as $job) {
                $this->outputString('- Retrying job #'.$job['id'], Console::FG_YELLOW);

                Craft::$app->getQueue()->retry($job['id']);
            }
        }

        $this->outputString('Finished', Console::BOLD, Console::FG_GREEN);
    }

    public function actionCancelAll()
    {
        $jobs = QueueManager::$plugin->queue->getJobIds();

        if (!$jobs) {
            $this->outputString('Error', Console::BOLD, Console::FG_RED);
            $this->outputString('- There are no jobs to cancel', Console::FG_RED);
        } else {
            foreach($jobs as $job) {
                $this->outputString('- Cancelling job #'.$job['id'], Console::FG_YELLOW);

                Craft::$app->getQueue()->release($job['id']);
            }
        }

        $this->outputString('Finished', Console::BOLD, Console::FG_GREEN);
    }

    // Private Methods
    // =========================================================================

    private function outputString($string)
    {
        $stream = \STDOUT;
        if (Console::streamSupportsAnsiColors($stream)) {
            $args = func_get_args();
            array_shift($args);
            $string = Console::ansiFormat($string, $args);
        }

        return Console::stdout($string.PHP_EOL);
    }
}
