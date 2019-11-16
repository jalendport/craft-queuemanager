<?php

namespace jalendport\queuemanager\models;

use Craft;
use craft\base\Model;

class Settings extends Model
{
    // Public Properties
    // =========================================================================

    public $jobLimit = 200;

    // Public Methods
    // =========================================================================

    public function rules()
    {
        return [
            [['jobLimit'], 'integer']
        ];
    }
}
