<?php

namespace lukeyouell\queuemanager\services;

use lukeyouell\queuemanager\QueueManager;

use Craft;
use craft\base\Component;

use yii\db\Query;

class QueueService extends Component
{
    // Public Methods
    // =========================================================================

    public function getJobs($status = null)
    {
        $query = $this->_createJobQuery();

        switch ($status) {
            case 'pending':
                $query->where(['fail' => false, 'timeUpdated' => null]);
                break;

            case 'reserved':
                $query->where(['and', ['fail' => false], ['not', ['timeUpdated' => null]]]);
                break;

            case 'failed':
                $query->where(['fail' => true]);
                break;
        }

        $results = $query->all();

        $info = [];

        foreach ($results as $result) {
            $info[] = [
                'id'          => $result['id'],
                'data'        => unserialize($result['job']),
                'description' => $result['description'],
                'timePushed'  => $result['timePushed'],
                'timeUpdated' => $result['timeUpdated'],
                'ttr'         => $result['ttr'],
                'priority'    => $result['priority'],
                'fail'        => (int)$result['fail'],
                'dateFailed'  => $result['dateFailed'],
                'error'       => $result['error'],
            ];
        }

        return $info;
    }

    public function getJobCount()
    {
        return (new Query())
            ->from('{{%queue}}')
            ->count();
    }

    // Private Methods
    // =========================================================================

    private function _createJobQuery(): Query
    {
        return (new Query())
            ->from('{{%queue}}')
            ->orderBy(['timePushed' => SORT_DESC])
            ->limit(200);
    }
}
