<?php

namespace humhub\modules\sponsors\assets;

use humhub\components\assets\AssetBundle;
use yii\web\View;

class SponsorsAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $jsOptions = [
        'position' => View::POS_END
    ];

    /**
     * @inheritdoc
     */
    public $sourcePath = '@sponsors/resources';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/humhub.sponsors.js'
    ];
}
