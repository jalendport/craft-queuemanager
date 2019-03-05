<?php

namespace lukeyouell\queuemanager\assetbundles;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class CpBundle extends AssetBundle
{
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = '@lukeyouell/queuemanager/assetbundles';

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'dist/app.js',
        ];

        $this->css = [
            'dist/app.css',
        ];

        parent::init();
    }
}
